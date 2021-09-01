<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "characteristics".
 *
 * @property int $id
 * @property string $name
 * @property int|null $filter_status
 */
class Characteristics extends \yii\db\ActiveRecord
{
    public $array;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'characteristics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['filter_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'array' => 'Характеристики',
            'filter_status' => 'Filter Status',
        ];
    }

    public function getCharacteristicsOptions() {
        return $this->hasMany(CharacteristicsOptions::className(),['characteristics_id'=>'id']);
    }
}
