<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Order;

class OrderController extends ActiveController
{
    public $modelClass = 'common\models\Order';

    public function init() {
        header("Access-Control-Allow-Origin: ".\Yii::$app->params['allowedHost']);
        header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, PATCH, HEAD");
        header("Access-Control-Allow-Headers: content-type");
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function actionCounters() {
        return ['count' => Order::find()->where('status_step1 = 100')->count()];
    }

    public function prepareDataProvider()
    {
        $query = Order::find();
        if (\Yii::$app->getRequest()->getQueryParam('date_from')) {
            $query = $query->andWhere('created_at >= :date_from', [':date_from' => \Yii::$app->getRequest()->getQueryParam('date_from')]);
        }
        if (\Yii::$app->getRequest()->getQueryParam('date_till')) {
            $query = $query->andWhere('created_at <= :date_till', [':date_till' => \Yii::$app->getRequest()->getQueryParam('date_till')]);
        }
        if (\Yii::$app->getRequest()->getQueryParam('step1')) {
            $query = $query->andWhere(['IN', 'status_step1', \Yii::$app->getRequest()->getQueryParam('step1')]);
        }
        if (\Yii::$app->getRequest()->getQueryParam('step2')) {
            $query = $query->andWhere(['IN', 'status_step2', \Yii::$app->getRequest()->getQueryParam('step2')]);
        }
        if (\Yii::$app->getRequest()->getQueryParam('step3')) {
            $query = $query->andWhere(['IN', 'status_step3', \Yii::$app->getRequest()->getQueryParam('step3')]);
        }
        if (\Yii::$app->getRequest()->getQueryParam('items')) {
            $query = $query->andWhere(['IN', 'item_id', \Yii::$app->getRequest()->getQueryParam('items')]);
        }
        if (\Yii::$app->getRequest()->getQueryParam('archive')) {
            return new ActiveDataProvider([
                'query' => $query
                            ->andWhere('(orders.status_step1 > 0 AND orders.status_step1 <= 50) OR (orders.status_step2 > 0 AND orders.status_step2 <= 50) OR (orders.status_step3 > 0 AND orders.status_step3 <= 50)'),
                'pagination' => false
            ]);
        } elseif (\Yii::$app->getRequest()->getQueryParam('newpostlist')) {
            return new ActiveDataProvider([
                'query' => $query
                            ->andWhere('status_step1 IN (110,112,114,115)')
                            ->andWhere('newpost_id = "" or newpost_id IS NULL')
                            ->andWhere('(status_step2 = 0 OR status_step2 > 50)')
                            ->andWhere('(status_step3 = 0 OR status_step3 > 50)'),
                'pagination' => false
            ]);
        } else {
            return new ActiveDataProvider([
                'query' => $query
                            ->andWhere('(orders.status_step1 = 0 OR orders.status_step1 > 50)')
                            ->andWhere('(orders.status_step2 = 0 OR orders.status_step2 > 50)')
                            ->andWhere('(orders.status_step3 = 0 OR orders.status_step3 > 50)'),
                'pagination' => false
            ]);
        }
    }
}



