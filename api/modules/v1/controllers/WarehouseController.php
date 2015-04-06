<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class WarehouseController extends ActiveController
{
    public $modelClass = 'common\models\Warehouse';

    public function init() {
        header("Access-Control-Allow-Origin: ".\Yii::$app->params['allowedHost']);
    }
}


