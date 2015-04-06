<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $id
 * @property string $name
 * @property string $act
 * @property string $domClass
 * @property string $row_domClass
 * @property integer $priority
 * @property integer $automatic
 * @property integer $archive_possible
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'act', 'domClass'], 'required'],
            [['id', 'priority', 'automatic'], 'integer'],
            [['name', 'act'], 'string', 'max' => 100],
            [['domClass', 'row_domClass'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'act' => 'Act',
            'domClass' => 'Dom Class',
            'row_domClass' => 'Row Dom Class',
            'priority' => 'Priority',
            'automatic' => 'Automatic',
        ];
    }
}
