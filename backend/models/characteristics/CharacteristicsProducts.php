<?php

namespace backend\models\characteristics;

use backend\models\products\Products;
use Yii;

/**
 * This is the model class for table "characteristics_products".
 *
 * @property int $id
 * @property int $characteristics_options_id
 * @property int $product_id
 *
 * @property CharacteristicsOptions $characteristicsOptions
 * @property Products $product
 */
class CharacteristicsProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'characteristics_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['characteristics_options_id', 'product_id'], 'required'],
            [['characteristics_options_id', 'product_id'], 'integer'],
            [['characteristics_options_id'], 'exist', 'skipOnError' => true, 'targetClass' => CharacteristicsOptions::className(), 'targetAttribute' => ['characteristics_options_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'characteristics_options_id' => 'Characteristics Options ID',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[CharacteristicsOptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicsOptions()
    {
        return $this->hasOne(CharacteristicsOptions::className(), ['id' => 'characteristics_options_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
