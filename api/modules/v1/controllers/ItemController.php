<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Item;

class ItemController extends ActiveController
{
    public $modelClass = 'common\models\Item';

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function init() {
        header("Access-Control-Allow-Origin: ".\Yii::$app->params['allowedHost']);
        header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, HEAD");
        header("Access-Control-Allow-Headers: content-type");
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Item::find()->andWhere('is_deleted = :is_deleted', [':is_deleted' => \Yii::$app->getRequest()->getQueryParam('is_deleted', 0)]),
            'pagination' => false
        ]);
    }
}



