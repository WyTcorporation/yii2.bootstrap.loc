<?php

namespace backend\models\wishlist;

use backend\models\products\Products;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "wishlist_items".
 *
 * @property int $id
 * @property int $wishlist_id
 * @property int $product_id
 * @property string $name
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 *
 * @property Wishlist $wishlist
 * @property Products $product
 */
class WishlistItems extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            //create_at, update_at
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
            ],
            //create_by, update_by
            'blameable' => [
                'class' => \yii\behaviors\BlameableBehavior::class,
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
        return 'wishlist_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wishlist_id', 'product_id', 'name'], 'required'],
            [['wishlist_id', 'product_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['wishlist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wishlist::className(), 'targetAttribute' => ['wishlist_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wishlist_id' => 'Wishlist ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_ip' => 'Created Ip',
            'updated_ip' => 'Updated Ip',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Wishlist]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlist()
    {
        return $this->hasOne(Wishlist::className(), ['id' => 'wishlist_id']);
    }
}
