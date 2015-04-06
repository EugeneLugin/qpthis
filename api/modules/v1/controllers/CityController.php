<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\City;

class CityController extends ActiveController
{
    public $modelClass = 'common\models\City';

    public function init() {
        header("Access-Control-Allow-Origin: ".\Yii::$app->params['allowedHost']);
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        if (\Yii::$app->getRequest()->getQueryParam('q')) {
            return new ActiveDataProvider([
                'query' => City::find()->andWhere('nameRu like :qname', [':qname' => \Yii::$app->getRequest()->getQueryParam('q').'%'])
                                       ->orWhere('nameUkr like :qname', [':qname' => \Yii::$app->getRequest()->getQueryParam('q').'%'])
                                       ->orderBy('nameRu'),
                'pagination' => false
            ]);
        } else {
            return new ActiveDataProvider([
                'query' => City::find()->orderBy('nameRu'),
                'pagination' => false
            ]);
        }
    }
}


