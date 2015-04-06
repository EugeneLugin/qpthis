<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders_audit".
 *
 * @property string $date
 * @property string $order_id
 * @property integer $user_id
 * @property string $comment
 * @property string $activity
 * @property string $details
 * @property string $newpost_backorder
 */
class OrderAudit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_audit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'activity'], 'required'],
            [['date'], 'safe'],
            [['user_id'], 'integer'],
            [['comment', 'details'], 'string'],
            [['order_id'], 'integer'],
            [['activity'], 'string', 'max' => 130],
            [['newpost_backorder'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'activity' => 'Activity',
            'details' => 'Details',
            'newpost_backorder' => 'Newpost Backorder',
        ];
    }
}
