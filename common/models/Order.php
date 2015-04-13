<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $alert_at
 * @property string $item_id
 * @property string $item_params
 * @property string $item_price
 * @property integer $item_count
 * @property string $city_area
 * @property string $address
 * @property string $fio
 * @property string $phone
 * @property string $phone2
 * @property string $phone3
 * @property string $email
 * @property string $newpost_id
 * @property string $newpost_answer
 * @property string $newpost_last_update
 * @property integer $status_step1
 * @property integer $status_step2
 * @property integer $status_step3
 * @property string $newpost_backorder
 * @property string $newpost_backorder_answer
 * @property string $newpost_last_backorder_update
 * @property string $comment
 * @property string $comment2
 * @property string $whs_ref
 * @property double $weight
 * @property integer $width
 * @property integer $length
 * @property integer $height
 * @property string $courier_adr
 */
class Order extends \yii\db\ActiveRecord
{
    var $no_audit = false;

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->no_audit) return true;

        $changes = [];
        foreach($changedAttributes as $key=>$value) {
            if (($key != 'comment') && ($this->$key != $value))
                $changes[$key] = ['old' => $value, 'new' => $this->$key];
        }
        if (!empty($changes) || ($this->comment && !empty($this->comment))) {
            $audit = new OrderAudit(['order_id' => $this->id, 'user_id' => 0, 'activity' => $insert ? 'добавление' : 'обновление']);
            if (!empty($changes)) $audit->details = Json::encode($changes);
            if ($this->comment) {
                $audit->comment = $this->comment;
                $this->comment = null;
            }
            $audit->save();
        }

        if (isset($changes['status_step1']) && $changes['status_step1']['new'] == 111) {
            $this->status_step2 = 201;
        }
        if (isset($changes['status_step2']) && $changes['status_step2']['new'] == 203) {
            $this->status_step3 = 311;
        }
        if (isset($changes['status_step2']) && $changes['status_step2']['new'] == 209) {
            $this->status_step3 = 311;
        }

        $this->no_audit = true;
        $this->save();
        $this->no_audit = false;

        return true;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'item_id', 'item_price', 'item_count', 'fio', 'phone'], 'required'],
            [['created_at', 'updated_at', 'alert_at', 'newpost_last_update', 'newpost_last_backorder_update'], 'safe'],
            [['item_count', 'status_step1', 'status_step2', 'status_step3', 'width', 'length', 'height'], 'integer'],
            [['newpost_answer', 'newpost_backorder_answer', 'comment', 'comment2'], 'string'],
            [['weight', 'item_price'], 'number'],
            [['item_id'], 'string', 'max' => 13],
            [['item_params', 'city_area', 'address', 'courier_adr'], 'string', 'max' => 200],
            [['fio', 'email'], 'string', 'max' => 100],
            [['phone', 'phone2', 'phone3'], 'string', 'max' => 50],
            [['newpost_id', 'newpost_backorder'], 'string', 'max' => 15],
            [['whs_ref'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'alert_at' => 'Alert At',
            'item_id' => 'Item ID',
            'item_params' => 'Item Params',
            'item_price' => 'Item Price',
            'item_count' => 'Item Count',
            'city_area' => 'City Area',
            'address' => 'Address',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'phone2' => 'Phone2',
            'phone3' => 'Phone3',
            'email' => 'Email',
            'newpost_id' => 'Newpost ID',
            'newpost_answer' => 'Newpost Answer',
            'newpost_last_update' => 'Newpost Last Update',
            'status_step1' => 'Status Step1',
            'status_step2' => 'Status Step2',
            'status_step3' => 'Status Step3',
            'newpost_backorder' => 'Newpost Backorder',
            'newpost_backorder_answer' => 'Newpost Backorder Answer',
            'newpost_last_backorder_update' => 'Newpost Last Backorder Update',
            'comment' => 'Comment',
            'comment2' => 'Comment2',
            'whs_ref' => 'Whs Ref',
            'weight' => 'Weight',
            'width' => 'Width',
            'length' => 'Length',
            'height' => 'Height',
            'courier_adr' => 'Courier Adr',
        ];
    }

    public function getOrderAudits()
    {
        return $this->hasMany(OrderAudit::className(), ['order_id' => 'id']);
    }
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['uuid' => 'item_id']);
    }
    public function getStep1()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_step1']);
    }
    public function getStep2()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_step2']);
    }
    public function getStep3()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_step3']);
    }
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['ref' => 'whs_ref']);
    }
    public function getFlysms()
    {
        return $this->hasMany(Flysms::className(), ['order_id' => 'id']);
    }

    public function extraFields()
    {
        return [
            'orderAudits',
            'item',
            'step1',
            'step2',
            'step3',
            'warehouse',
            'flysms'
        ];
    }
}
