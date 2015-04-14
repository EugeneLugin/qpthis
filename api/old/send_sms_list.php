<?php
	require("config.php");
	mb_internal_encoding("UTF-8");
	libxml_use_internal_errors(true);

	function send_sms($text, $rcpt, $order_id, $alpha, $type=1) {
        if (isset($_GET['set'])) return;
		global $db, $smsfly_user, $smsfly_password;

		$text = htmlspecialchars($text);
		$description = htmlspecialchars('Уведомление об отправке');
		$start_time = "AUTO";
		$end_time = "AUTO";
		$rate = 120;
		$livetime = 24;
		$source = ($alpha ? trim($alpha) : 'SMS'); // Alfaname
		$recipient = $rcpt;

		$myXML 	 = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$myXML 	.= "<request>";
		$myXML 	.= "<operation>SENDSMS</operation>";
		$myXML 	.= '		<message start_time="'.$start_time.'" end_time="'.$end_time.'" livetime="'.$livetime.'" rate="'.$rate.'" desc="'.$description.'" source="'.$source.'">'."\n";
		$myXML 	.= "		<body>".htmlspecialchars($text, ENT_QUOTES, 'UTF-8')."</body>";
		$myXML 	.= "		<recipient>".$recipient."</recipient>";
		$myXML 	.=  "</message>";
		$myXML 	.= "</request>";

        $ch = curl_init();
		curl_setopt($ch, CURLOPT_USERPWD , $smsfly_user.':'.$smsfly_password);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://sms-fly.com/api/api.php');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Accept: text/xml"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $myXML);
		$response = curl_exec($ch);
		curl_close($ch);

		/*$response = '<?xml version="1.0" encoding="utf-8"?><message><state code="ACCEPT" campaignID="3447610" date="2013-11-08 03:55:08">The campaign has been successfully processed and added to the queue for delivery</state><to recipient="380973390911" status="ACCEPTED"></to></message>';*/
		echo $response;

		try {
			$status = new SimpleXMLElement($response);

			$query1 = "INSERT INTO flysms (status,date,campaignID,recipient,order_id,type,text) VALUES (:status,:date,:campaignID,:recipient,:order_id,:type,:text)";

			echo print_r($status->state->attributes(),true);
			echo $status->state->attributes()->campaignID;

			$query_params1 = array(
				':campaignID' => $status->state->attributes()->campaignID,
				':recipient' => $rcpt,
				':order_id' => $order_id,
				':type' => $type,
				':status' => $status->state->attributes()->code,
				':date' => $status->state->attributes()->date,
                ':text' => $text
			);

			try{
				$stmt1 = $db->prepare($query1);
				$result = $stmt1->execute($query_params1);
			}
			catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }


		} catch (Exception $e) {
			echo $response;
		}

		if ($alpha and $status->state->attributes()->code == 'ERRALFANAME') {
			send_sms($text, $rcpt, $order_id, null);
		}
	}

	$query = "
		SELECT
		    'HochuKupit' as alphaname,
			orders.id as id,
			orders.item_id as item_id,
			orders.item_price as item_price,
			orders.item_params as item_params,
			orders.item_count as item_count,
			orders.city_area as city_area,
			orders.address as address,
			orders.courier_adr as courier_adr,
			orders.fio as fio,
			orders.phone as phone,
			orders.email as email,
			orders.newpost_id as newpost_id,
			orders.newpost_answer as newpost_answer,
			orders.status_step2 as status_step2,
			item.short_name as short_name
		   FROM orders JOIN item ON orders.item_id = item.uuid
			WHERE
				HOUR(NOW()) >= 9 AND
				HOUR(NOW()) <= 20 AND
				orders.status_step1 > 50 AND
				orders.status_step2 IN (202, 208, 200, 204, 205, 206, 250) AND
				orders.status_step3 = 0
		";
	$query_params = array();

	try{
		$stmt = $db->prepare($query);
		$result = $stmt->execute($query_params);
	}
	catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }
	$orders = $stmt->fetchAll();

	foreach ($orders as $ord) {
		$np_answer = json_decode($ord['newpost_answer'], true);
		if ($np_answer['arrival_date']) {
			$query_sms = "SELECT
				date,
				status
			FROM flysms WHERE type = 1 AND order_id = :order_id";// AND status = 'DELIVERED'";
			$query_params = array(':order_id' => $ord['id']);

			try{
				$stmt = $db->prepare($query_sms);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }

			$delivered = $stmt->fetch();

			if (!$delivered) {
				$query_sms = "SELECT
					date,
					status
				FROM flysms WHERE order_id = :order_id AND HOUR(TIMEDIFF(NOW(), date)) < 24";
				$query_params = array(':order_id' => $ord['id']);

				try{
					$stmt = $db->prepare($query_sms);
					$result = $stmt->execute($query_params);
				}
				catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }

				$this_day_sent = $stmt->fetch();

				if (!$this_day_sent and !in_array($ord['status_step2'], array(208,209,210,220,221,225,230,240,241,242) )){
					$rexp_sd = '/(\d\d\.\d\d)\.\d\d\d\d/';
					preg_match($rexp_sd, $np_answer['arrival_date'], $short_date);
					$rexp_adr = '/[^\d]*(\d*).*?:([^\(<]*)/';
					preg_match($rexp_adr, $np_answer['address'], $short_adr);
                    $whsn = ($short_adr[1] && !empty($short_adr[1])) ? $short_adr[1].':' : '';
					$short_adr = trim($short_adr[2]);
					$sms_text = $ord['fio'].'! Ваш заказ '.$ord['short_name'].' ТТН '.$ord['newpost_id'].' прибудет '.$short_date[1].' на склад '.$whsn.$short_adr;
                    $sms_text = $sms_text.substr(0,210);

                    echo $ord['phone'].' #';
                    echo $ord['id'].': ';
                    echo $sms_text.'<br>';

					if (isset($_GET['view'])) {
						continue;
					}

					send_sms($sms_text,"38".str_replace(array('(',')','-'), "", $ord['phone']),$ord['id'],(($ord['alphaname'] and $ord['alphaname'] != '') ? $ord['alphaname'] : null));

					if (in_array($ord['status_step2'], array(200,250))) {
						$query = "UPDATE orders SET status_step2 = :status_step2 WHERE id = :order_id";

						$query_params = array(
							':status_step2' => 202,
							':order_id' => $ord['id']
						);

						try{
							$stmt = $db->prepare($query);
							$result = $stmt->execute($query_params);
						}
						catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }

						$query = "INSERT INTO orders_audit(date, order_id, user_id, activity, details) VALUES
									(	NOW(),
										:order_id,
										:user_id,
										:activity,
										:details		)";

						$query_params = array(
							':details' => $sms_text,
							':activity' => 'Отправлено SMS: '.$sms_text,
							':user_id' => 1,
							':order_id' => $ord['id']
						);

						try{
							$stmt = $db->prepare($query);
							$result = $stmt->execute($query_params);
						}
						catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }
					}
				}
			}
		}
	}

    $query = "
        SELECT
		    'HochuKupit' as alphaname,
			orders.id as id,
			orders.item_id as item_id,
			orders.item_price as item_price,
			orders.item_params as item_params,
			orders.item_count as item_count,
			orders.city_area as city_area,
			orders.address as address,
			orders.courier_adr as courier_adr,
			orders.fio as fio,
			orders.phone as phone,
			orders.email as email,
			orders.newpost_id as newpost_id,
			orders.newpost_answer as newpost_answer,
			orders.status_step2 as status_step2,
			item.short_name as short_name
		   FROM orders JOIN item ON orders.item_id = item.uuid
			WHERE
				HOUR(NOW()) >= 0 AND
				HOUR(NOW()) <= 23 AND
				orders.status_step1 > 50 AND
				orders.status_step2 IN (207, 223) AND
				orders.status_step3 = 0
		";
	$query_params = array();

	try{
		$stmt = $db->prepare($query);
		$result = $stmt->execute($query_params);
	}
	catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }
	$orders = $stmt->fetchAll();

	foreach ($orders as $ord) {
		$query_sms = "SELECT
			date,
			status
		FROM flysms WHERE type = 2 AND order_id = :order_id";// AND status = 'DELIVERED'";
		$query_params = array(':order_id' => $ord['id']);

		try{
			$stmt = $db->prepare($query_sms);
			$result = $stmt->execute($query_params);
		}
		catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }

		$delivered = $stmt->fetch();

		if (!$delivered) {
			/*$query_sms = "SELECT
				date,
				status
			FROM flysms WHERE type=2 AND order_id = :order_id AND HOUR(TIMEDIFF(NOW(), date)) < 24";
			$query_params = array(':order_id' => $ord['id']);

			try{
				$stmt = $db->prepare($query_sms);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }

			$this_day_sent = $stmt->fetch();*/
			$this_day_sent = false;

			if (!$this_day_sent) {
                $np_answer = json_decode($ord['newpost_answer'], true);
                $rexp_adr = '/[^\d]*(\d*).*?:([^\(<]*)/';
                preg_match($rexp_adr, $np_answer['address'], $short_adr);
                $whsn = ($short_adr[1] && !empty($short_adr[1])) ? $short_adr[1].':' : '';
                $short_adr = trim($short_adr[2]);

                $sms_text = 'ПРИБЫЛ. '.($ord['status_step2']==223 ? 'Получите сегодня пожалуйста! ':'Приглашаем получить! ').$ord['short_name'].' ТТН '.$ord['newpost_id'].' склад '.$whsn.$short_adr;;
				echo $ord['phone'].' #';
				echo $ord['id'].': ';
				echo $sms_text.'<br>';

				if (isset($_GET['view'])) {
					continue;
				}

                send_sms($sms_text,"38".str_replace(array('(',')','-'), "", $ord['phone']),$ord['id'],(($ord['alphaname'] and $ord['alphaname'] != '') ? $ord['alphaname'] : null),$ord['status_step2']==223 ? 3: 2);

                $query = "INSERT INTO orders_audit(date, order_id, user_id, activity, details) VALUES
									(	NOW(),
										:order_id,
										:user_id,
										:activity,
										:details		)";

                $query_params = array(
                    ':details' => $sms_text,
                    ':activity' => 'Отправлено SMS: '.$sms_text,
                    ':user_id' => 1,
                    ':order_id' => $ord['id']
                );

                try{
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                }
                catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }
			}
		}
	}
?>