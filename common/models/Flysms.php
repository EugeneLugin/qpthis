<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flysms".
 *
 * @property string $order_id
 * @property integer $type
 * @property integer $campaignID
 * @property string $recipient
 * @property string $status
 * @property string $date
 */
class Flysms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flysms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'recipient', 'status', 'date'], 'required'],
            [['order_id', 'type', 'campaignID'], 'integer'],
            [['date'], 'safe'],
            [['recipient'], 'string', 'max' => 12],
            [['status'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'type' => 'Type',
            'campaignID' => 'Campaign ID',
            'recipient' => 'Recipient',
            'status' => 'Status',
            'date' => 'Date',
        ];
    }
}
