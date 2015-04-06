<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property string $ref
 * @property integer $id
 * @property string $nameRu
 * @property string $nameUkr
 * @property integer $saturdayDelivery
 * @property string $parentCityRef
 * @property integer $parentCityId
 * @property string $parentCityNameRu
 * @property string $parentCityNameUkr
 * @property string $areaNameUkr
 * @property integer $is_agent
 *
 * @property Warehouse[] $warehouses
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
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
            'id' => 'ID',
            'nameRu' => 'Name Ru',
            'nameUkr' => 'Name Ukr',
            'saturdayDelivery' => 'Saturday Delivery',
            'parentCityRef' => 'Parent City Ref',
            'parentCityId' => 'Parent City ID',
            'parentCityNameRu' => 'Parent City Name Ru',
            'parentCityNameUkr' => 'Parent City Name Ukr',
            'areaNameUkr' => 'Area Name Ukr',
            'is_agent' => 'Is Agent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouses()
    {
        return $this->hasMany(Warehouse::className(), ['city_ref' => 'ref'])
                    ->orderBy('number');
    }

    public function extraFields()
    {
        return [
            'warehouses'
        ];
    }
}
