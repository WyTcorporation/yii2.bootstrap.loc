<?php

namespace backend\models\orders;

use backend\models\user\User;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property int|null $address
 * @property int $qty
 * @property float $sum
 * @property int|null $payment
 * @property int|null $shipping
 * @property string|null $status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 *
 * @property User $user
 * @property OrdersItems[] $ordersItems
 */
class Orders extends \yii\db\ActiveRecord
{
    public $search;

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
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'email', 'phone', 'qty', 'sum'], 'required'],
            [['user_id',  'qty', 'payment', 'shipping'], 'integer'],
            [['sum'], 'number'],
            [['status','address'], 'string'],
            ['email', 'email'],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => Yii::t('backend/attributes', 'User'),
            'payment' => Yii::t('backend/attributes', 'Payment'),
            'shipping' => Yii::t('backend/attributes', 'Shipping'),
            'qty' => Yii::t('backend/attributes', 'Quantity'),
            'sum' => Yii::t('backend/attributes', 'Sum'),
            'status' => Yii::t('backend/attributes', 'Paid up'),
            'name' => Yii::t('backend/attributes', 'FIO'),
            'email' => 'Email',
            'phone' => Yii::t('backend/attributes', 'Phone'),
            'address' => Yii::t('backend/attributes', 'Address'),
            'search' => Yii::t('backend/buttons', 'Search'),
            'created_at' => Yii::t('backend/attributes', 'date of creation'),
            'updated_at' => Yii::t('backend/attributes', 'Update date'),
            'created_ip' => Yii::t('backend/attributes', 'Created with IP'),
            'updated_ip' => Yii::t('backend/attributes', 'Updated from IP'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[OrdersItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersItems()
    {
        return $this->hasMany(OrdersItems::className(), ['order_id' => 'id']);
    }
}
