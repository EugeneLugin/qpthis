<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class OrderAuditController extends ActiveController
{
    public $modelClass = 'common\models\OrderAudit';

    public function init() {
        header("Access-Control-Allow-Origin: ".\Yii::$app->params['allowedHost']);
        header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, HEAD");
        header("Access-Control-Allow-Headers: content-type");
    }
}



