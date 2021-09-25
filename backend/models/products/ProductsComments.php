<?php

namespace backend\models\products;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "products_comments".
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $comment
 * @property int $rating
 * @property int $active
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 *
 * @property Products $product
 */
class ProductsComments extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            //create_at, update_at
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
            ],
            //create_ip, update_ip
            'ip' => [
                'class' => \yii\behaviors\AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_ip',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_ip',
                ],
                'value' => function ($event) {
                    return Yii::$app->request->getUserIP();
                },
            ],

        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'name', 'comment', 'rating'], 'required'],
            [['product_id', 'rating'], 'integer'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 255],
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
            'product_id' => Yii::t('backend', 'Products'),
            'active' => Yii::t('backend/attributes', 'Publication'),
            'name' => Yii::t('backend', 'Author'),
            'comment' => Yii::t('backend/attributes', 'Comment'),
            'rating' => Yii::t('backend/attributes', 'Rating'),
            'created_at' => Yii::t('backend/attributes', 'date of creation'),
            'updated_at' => Yii::t('backend/attributes', 'Update date'),
            'created_ip' => Yii::t('backend/attributes', 'Created with IP'),
            'updated_ip' => Yii::t('backend/attributes', 'Updated from IP'),
        ];
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
