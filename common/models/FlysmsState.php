<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flysms_state".
 *
 * @property string $state
 * @property string $name
 * @property string $color
 */
class FlysmsState extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flysms_state';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state', 'name'], 'required'],
            [['state'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'state' => 'State',
            'name' => 'Name',
            'color' => 'Color',
        ];
    }
}
