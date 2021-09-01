<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "characteristics_products".
 *
 * @property int $id
 * @property int $product_id
 * @property int $characteristics_options_id
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
//            [['product_id', 'characteristics_options'], 'required'],
            [['product_id', 'characteristics_options_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'characteristics_options_id' => 'Characteristics Options',
        ];
    }

    public function getCharacteristicsOptions() {
        return $this->hasOne(CharacteristicsOptions::className(),['id' => 'characteristics_options_id']);
    }

    public function getProducts() {
        return $this->hasMany(Product::className(),['product_id'=>'id']);
    }
}
