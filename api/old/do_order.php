<?php
    require("config.php");     

	if (!$_POST['phone'] OR !$_POST['id']) {
		die("Форма заказа заполнена не полностью!");
	}
	
	$query = "SELECT * FROM item WHERE uuid = :uuid";
	$query_params = array (
		':uuid' => $_POST['id']
	);
	try{ 
		$stmt = $db->prepare($query); 
		$result = $stmt->execute($query_params); 
	} 
	catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); } 
	
	$sel_item = $stmt->fetch();

	if (!$sel_item) {
		die('Извините, этот товар уже не продаётся');
	}
		
	$comment = '';
	
	$query = " 
            INSERT INTO orders(item_id, item_price, item_params, item_count, city_area, address, fio, phone, email)
				 VALUES (:item_id, :item_price, :item_params, :item_count, :city_area, :address, :fio, :phone, :email);
        "; 
	$query_params = array( 
		':item_id' => $_POST['id'],
		':item_price' => number_format(floatval($sel_item['price'])*intval($_POST['count'] ? $_POST['count'] : 1),2,'.',''),
		':item_params' => (isset($_POST['param1']) ? $sel_item['param1_name'].':'.$_POST['param1'] : '').(isset($_POST['param2']) ? ' '.$sel_item['param2_name'].':'.$_POST['param2'] : ''),
		':item_count' => $_POST['count'] ? $_POST['count'] : 1,
		':city_area' => $_POST['city'].' '.$_POST['area'],
		':address' => $_POST['address'], 
		':fio' => $_POST['fam'].' '.$_POST['name'], 
		':phone' => preg_replace('/[\(\)-]+/','',$_POST['phone']),
		':email' => $_POST['email']
	);
	 
	try {
		$stmt = $db->prepare($query); 
		$result = $stmt->execute($query_params); 
	} 
	catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }

    $details = [
        'item_id' => ['new' => $_POST['id']],
        'item_price' => ['new' => number_format(floatval($sel_item['price'])*intval($_POST['count'] ? $_POST['count'] : 1),2,'.','')],
        'item_params' => ['new' => (isset($_POST['param1']) ? $sel_item['param1_name'].':'.$_POST['param1'] : '').(isset($_POST['param2']) ? ' '.$sel_item['param2_name'].':'.$_POST['param2'] : '')],
        'item_count' => ['new' => $_POST['count'] ? $_POST['count'] : 1],
        'city_area' => ['new' => $_POST['city'].' '.$_POST['area']],
        'address' => ['new' => $_POST['address']],
        'fio' => ['new' => $_POST['fam'].' '.$_POST['name']],
        'phone' => ['new' => preg_replace('/[\(\)-]+/','',$_POST['phone'])],
        'email' => ['new' => $_POST['email']],
    ];

    $query = "
                INSERT INTO orders_audit(order_id, user_id, activity, details)
                     VALUES (:order_id, :user_id, :activity, :details);
            ";
    $query_params = array(
        ':order_id' => $db->lastInsertId(),
        ':user_id' => 1,
        ':activity' => 'создание',
        ':details' => json_encode($details)
    );

    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ваш заказ принят!</title>
    <style type="text/css">
        #posts {
            width: 860px;
            position:relative;
            margin-top: 10px;
            border-top:1px solid #CCCCCC;
            border-bottom:0px;
            border-left:1px solid #CCCCCC;
            border-right:1px solid #CCCCCC;
            padding-bottom: 10px;
            padding-top:0px;
        }
        .posts_footer {
            border-top:0px;
            border-bottom:1px solid #CCCCCC;
            border-left:1px solid #CCCCCC;
            border-right:1px solid #CCCCCC;
            position:relative;
            width:860px;
            margin-top:0px;
            margin-bottom:5px;
        }
        .ltc {
            background-image: url(image/corner10.gif);
            position: absolute;
            left: -1px;
            top: -1px;
            background-position: 0px 0px;
        }
        .rtc {
            background-image: url(image/corner11.gif);
            position: absolute;
            top: -1px;
            right: -1px;
            background-position: 10px 0px;
        }
        .ldc {
            background-image: url(image/corner12.gif);
            position: absolute;
            left: -1px;
            bottom: -1px;
            background-position: left bottom;
            background-repeat: no-repeat;
        }
        .rdc {
            background-image: url(image/corner13.gif);
            position: absolute;
            bottom: -1px;
            right: -1px;
            background-position: right bottom;
            background-repeat: no-repeat;
        }
        .ltc, .rtc, .ldc, .rdc {height: 20px; width: 10px; z-index: 100}
        p {
            font: normal 11pt Verdana, Arial, Helvetica, sans-serif;
            text-indent : 0cm;
            margin:10px;
            margin-bottom: 0px;
            color : #000000;
            padding-bottom: 0px;
        }
    </style>
</head>
<body>
<?php if ($sel_item['yandexmetric'] and $sel_item['yandexgoal2']) { ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter<?php echo $sel_item['yandexmetric'] ?> = new Ya.Metrika({id:<?php echo $sel_item['yandexmetric'] ?>,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");

yaCounter<?php echo $sel_item['yandexmetric'] ?>.reachGoal('<?php echo $sel_item['yandexgoal2'] ?>');
</script>
<!-- /Yandex.Metrika counter -->
<?php } ?>
<div align="center">
	<!--Header-->
	
	<div id="posts">
		<span class="ltc"></span><span class="rtc"></span>
		<?php if ($sel_item['finish_screen']) {
			echo stripcslashes(str_replace("{surname}",$_POST['fam'],str_replace("{name}",$_POST['name'],str_replace("{item}",$sel_item['name'],$sel_item['finish_screen']))));
		} else { ?>

			<h2>Благодарю Вас за заказ!</h2>

			<div align="center">
			  <div align="center">

				<p><strong>Ваш заказ принят!</strong></p>

				<p align="left"><br />Ваш заказ успешно принят и поставлен в обработку!</p>
				<p align="left">В ближайшее время Ваш заказ будет подготовлен и отправлен на указанный Вами адрес.</p>
				</div>
			  <p>&nbsp;</p>
			</div>		  
		  <?php } ?>		
	</div>
	<div class="posts_footer"><span class="ldc"></span><span class="rdc"></span></div>
	<div id="footer">
	</div>
</div>
</body>
</html>

