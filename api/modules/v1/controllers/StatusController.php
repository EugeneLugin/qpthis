<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Status;

class StatusController extends ActiveController
{
    public $modelClass = 'common\models\Status';

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
        if (\Yii::$app->getRequest()->getQueryParam('step1')) {
            return new ActiveDataProvider([
                'query' => Status::find()
                            ->where('step1 = 1'),
                'pagination' => false
            ]);
        } elseif (\Yii::$app->getRequest()->getQueryParam('step2')) {
            return new ActiveDataProvider([
                'query' => Status::find()
                    ->where('step2 = 1'),
                'pagination' => false
            ]);
        } elseif (\Yii::$app->getRequest()->getQueryParam('step3')) {
            return new ActiveDataProvider([
                'query' => Status::find()
                    ->where('step3 = 1'),
                'pagination' => false
            ]);
        } elseif (\Yii::$app->getRequest()->getQueryParam('stepA')) {
            return new ActiveDataProvider([
                'query' => Status::find()
                    ->where('stepA = 1'),
                'pagination' => false
            ]);
        } else {
            return new ActiveDataProvider([
                'query' => Status::find()
            ]);
        }
    }
}


