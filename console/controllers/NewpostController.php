<?php

namespace console\controllers;

use \common\models\City;
use \common\models\Warehouse;

class NewpostController extends \yii\console\Controller
{
    function actionIndex() {
        echo "Hello!";
    }

    function actionDictionaries() {
        echo "Start loading dictionaries\n";

        //$i_query = 'TRUNCATE TABLE cities; TRUNCATE TABLE warehouses; ';

        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><file><auth>".\Yii::$app->params['newpost_api_key']."</auth><city/></file>";

        //TODO: URL to config
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['newpost_api_url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        $xml_cities = new \SimpleXMLElement($response);

        $idx=0;
        while($city = $xml_cities->result->cities->city[$idx]) {
            $new_city = City::find()->where(['ref' => $city->ref])->one();
            if (!$new_city) $new_city = new City;
            foreach($city as $key=>$value) $new_city->setAttribute($key, $value);
            if (!$new_city->save()) echo '-';
            $idx++;
        }
        echo "Cities loaded\n";

        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><file><auth>".\Yii::$app->params['newpost_api_key']."</auth><warenhouse/></file>";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);
        curl_close($ch);

        $xml_warehouses = new \SimpleXMLElement($response);
        $idx=0;
        while($whs = $xml_warehouses->result->whs->warenhouse[$idx]) {
            $new_whs = Warehouse::find()->where(['ref' => $whs->ref])->one();
            if (!$new_whs) $new_whs = new Warehouse();
            foreach($whs as $key=>$value) $new_whs->setAttribute($key, $value);
            if (!$new_whs->save()) echo '-';
            $idx++;
        }

        echo "Warehouses loaded\n";
        echo "Finish loading dictionaries\n";
        return 0;
    }
}