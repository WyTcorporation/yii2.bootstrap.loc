<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "characteristics_options".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $characteristics_id
 */
class CharacteristicsOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'characteristics_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'characteristics_id'], 'required'],
            [['name', 'value'], 'string'],
            [['characteristics_id'], 'integer'],
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
            'value' => 'Value',
            'characteristics_id' => 'Characteristics ID',
        ];
    }

    public function getCharacteristics() {
        return $this->hasOne(Characteristics::className(),['id'=>'characteristics_id']);
    }

    public function getCharacteristicsProducts() {
        return $this->hasMany(CharacteristicsProducts::className(),['characteristics_options_id'=>'id']);
    }
}
