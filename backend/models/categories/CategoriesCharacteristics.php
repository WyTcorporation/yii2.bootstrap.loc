<?php

namespace backend\models\categories;

use backend\models\characteristics\Characteristics;
use Yii;

/**
 * This is the model class for table "categories_characteristics".
 *
 * @property int $id
 * @property int $categories_id
 * @property int $characteristics_id
 * @property array $array
 *
 * @property Categories $categories
 * @property Characteristics $characteristics
 */
class CategoriesCharacteristics extends \yii\db\ActiveRecord
{
    public $array;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_characteristics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categories_id', 'characteristics_id'], 'required'],
            [['categories_id', 'characteristics_id'], 'integer'],
            [['categories_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['categories_id' => 'id']],
            [['characteristics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Characteristics::className(), 'targetAttribute' => ['characteristics_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categories_id' => 'Categories ID',
            'characteristics_id' => 'Characteristics ID',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasOne(Categories::className(), ['id' => 'categories_id']);
    }

    /**
     * Gets query for [[Characteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristics()
    {
        return $this->hasOne(Characteristics::className(), ['id' => 'characteristics_id']);
    }
}
