<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $qty
 * @property int $shipping
 * @property int $payment
 * @property float $sum
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property int $user_id
 */
class Order extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }


//        $payment_method = [
//            0=> 'Не определено',
//            1 => 'Карта',
//            2 => 'При получении на НП',
//            2 => 'При получении на НП',
//            2 => 'При получении на НП'
//        ];
//
//        $shipping_method = [
//            0=> 'Не определено',
//            1 => 'Самовывоз',
//            2 => 'НП'
//        ];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['created_at', 'updated_at'], 'safe'],
            [['qty', 'payment', 'shipping'], 'integer'],
            [['sum'], 'number'],
            [['status'], 'string'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],

            [['user_id'], 'integer'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'qty' => 'Qty',
            'sum' => 'Sum',
            'status' => 'Status',
            'name' => 'ФИО',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'address' => 'Адресс',
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCost()
    {
        return $this->sum;
    }

    function setPaymentStatus($status)
    {
        if($status == 'yes') {
            $this->status = 1;
        } else {
            $this->status = 0;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param int $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
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
}
