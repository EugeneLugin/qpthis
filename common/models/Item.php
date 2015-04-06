<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property string $uuid
 * @property string $name
 * @property string $short_name
 * @property string $url
 * @property double $price
 * @property string $yandexmetric
 * @property string $yandexgoal
 * @property string $yandexgoal2
 * @property double $weight
 * @property double $width
 * @property double $height
 * @property double $length
 * @property integer $is_deleted
 * @property integer $inactive
 * @property string $param1_name
 * @property string $param2_name
 * @property string $param1
 * @property string $param2
 * @property string $finish_screen
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    public static function primaryKey()
    {
        return ['uuid'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uuid', 'name', 'short_name'], 'required'],
            [['price', 'weight', 'width', 'height', 'length'], 'number'],
            [['is_deleted', 'inactive'], 'integer'],
            [['uuid'], 'string', 'max' => 13],
            [['name'], 'string', 'max' => 100],
            [['short_name', 'yandexgoal', 'yandexgoal2'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 128],
            [['yandexmetric'], 'string', 'max' => 10],
            [['param1_name', 'param2_name'], 'string', 'max' => 50],
            [['param1', 'param2'], 'string', 'max' => 500],
            [['uuid'], 'unique'],
            [['finish_screen'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uuid' => 'Uuid',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'url' => 'Url',
            'price' => 'Price',
            'yandexmetric' => 'Yandexmetric',
            'yandexgoal' => 'Yandexgoal',
            'yandexgoal2' => 'Yandexgoal2',
            'weight' => 'Weight',
            'width' => 'Width',
            'height' => 'Height',
            'length' => 'Length',
            'is_deleted' => 'Is Deleted',
            'inactive' => 'Inactive',
            'param1_name' => 'Param1 Name',
            'param2_name' => 'Param2 Name',
            'param1' => 'Param1',
            'param2' => 'Param2',
            'finish_screen' => 'Finish Screen',
        ];
    }
}
