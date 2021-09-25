<?php

namespace backend\models\categories;

use Yii;

/**
 * This is the model class for table "categories_percent".
 *
 * @property int $id
 * @property int $categories_id
 * @property int $role
 * @property string $content
 * @property array $array
 *
 * @property Categories $categories
 */
class CategoriesPercent extends \yii\db\ActiveRecord
{
    public $array;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_percent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categories_id', 'role', 'content'], 'required'],
            [['categories_id', 'role'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [['categories_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['categories_id' => 'id']],
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
            'role' => 'Role',
            'content' => 'Проценты',
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
}
