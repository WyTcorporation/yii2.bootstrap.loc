<?php

namespace backend\models\callback;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "call_back".
 *
 * @property int $id
 * @property string $telephone
 * @property string $product_name
 * @property string|null $status
 * @property int $created_at
 * @property int|null $updated_at
 * @property string $created_ip
 * @property string|null $updated_ip
 */
class CallBack extends \yii\db\ActiveRecord
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
        return 'call_back';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telephone', 'product_name',], 'required'],
            [['status'], 'string'],
            [['telephone', 'product_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'telephone' => Yii::t('backend/attributes', 'Phone'),
            'product_name' => Yii::t('backend/attributes', 'name'),
            'status' => Yii::t('backend/attributes', 'Close'),
            'created_at' => Yii::t('backend/attributes', 'date of creation'),
            'updated_at' => Yii::t('backend/attributes', 'Update date'),
            'created_ip' => Yii::t('backend/attributes', 'Created with IP'),
            'updated_ip' => Yii::t('backend/attributes', 'Updated from IP'),
        ];
    }
}
