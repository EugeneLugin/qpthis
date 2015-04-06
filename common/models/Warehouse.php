<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property string $ref
 * @property string $city_ref
 * @property integer $city_id
 * @property string $city
 * @property string $cityRu
 * @property string $address
 * @property string $addressRu
 * @property integer $number
 * @property integer $wareId
 * @property string $phone
 * @property string $weekday_work_hours
 * @property string $weekday_reseiving_hours
 * @property string $weekday_delivery_hours
 * @property string $saturday_work_hours
 * @property string $saturday_reseiving_hours
 * @property string $saturday_delivery_hours
 * @property integer $max_weight_allowed
 * @property double $x
 * @property double $y
 * @property string $working_monday
 * @property string $working_tuesday
 * @property string $working_wednesday
 * @property string $working_thursday
 * @property string $working_friday
 * @property string $working_saturday
 * @property string $working_sunday
 * @property string $departure_monday
 * @property string $departure_tuesday
 * @property string $departure_wednesday
 * @property string $departure_thursday
 * @property string $departure_friday
 * @property string $departure_saturday
 * @property string $departure_sunday
 * @property string $receipt_monday
 * @property string $receipt_tuesday
 * @property string $receipt_wednesday
 * @property string $receipt_thursday
 * @property string $receipt_friday
 * @property string $receipt_saturday
 * @property string $receipt_sunday
 *
 * @property City $cityRef
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    public static function primaryKey()
    {
        return ['ref'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ref' => 'Ref',
            'city_ref' => 'City Ref',
            'city_id' => 'City ID',
            'city' => 'City',
            'cityRu' => 'City Ru',
            'address' => 'Address',
            'addressRu' => 'Address Ru',
            'number' => 'Number',
            'wareId' => 'Ware ID',
            'phone' => 'Phone',
            'weekday_work_hours' => 'Weekday Work Hours',
            'weekday_reseiving_hours' => 'Weekday Reseiving Hours',
            'weekday_delivery_hours' => 'Weekday Delivery Hours',
            'saturday_work_hours' => 'Saturday Work Hours',
            'saturday_reseiving_hours' => 'Saturday Reseiving Hours',
            'saturday_delivery_hours' => 'Saturday Delivery Hours',
            'max_weight_allowed' => 'Max Weight Allowed',
            'x' => 'X',
            'y' => 'Y',
            'working_monday' => 'Working Monday',
            'working_tuesday' => 'Working Tuesday',
            'working_wednesday' => 'Working Wednesday',
            'working_thursday' => 'Working Thursday',
            'working_friday' => 'Working Friday',
            'working_saturday' => 'Working Saturday',
            'working_sunday' => 'Working Sunday',
            'departure_monday' => 'Departure Monday',
            'departure_tuesday' => 'Departure Tuesday',
            'departure_wednesday' => 'Departure Wednesday',
            'departure_thursday' => 'Departure Thursday',
            'departure_friday' => 'Departure Friday',
            'departure_saturday' => 'Departure Saturday',
            'departure_sunday' => 'Departure Sunday',
            'receipt_monday' => 'Receipt Monday',
            'receipt_tuesday' => 'Receipt Tuesday',
            'receipt_wednesday' => 'Receipt Wednesday',
            'receipt_thursday' => 'Receipt Thursday',
            'receipt_friday' => 'Receipt Friday',
            'receipt_saturday' => 'Receipt Saturday',
            'receipt_sunday' => 'Receipt Sunday',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityRef()
    {
        return $this->hasOne(City::className(), ['ref' => 'city_ref']);
    }
}
