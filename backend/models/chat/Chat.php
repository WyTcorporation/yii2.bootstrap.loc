<?php

namespace backend\models\chat;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int|null $first_user_id
 * @property int|null $second_user_id
 * @property string|null $message
 * @property string|null $images
 * @property string|null $video
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 */
class Chat extends \yii\db\ActiveRecord
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
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_user_id', 'second_user_id'], 'integer'],
            [['message', 'images', 'video'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_user_id' => 'First User ID',
            'second_user_id' => 'Second User ID',
            'message' => 'Message',
            'images' => 'Images',
            'video' => 'Video',
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'created_by' => Yii::t('app', 'Создано пользователем'),
            'updated_by' => Yii::t('app', 'Обновлено пользователем'),
            'created_ip' => Yii::t('app', 'Создано c IP'),
            'updated_ip' => Yii::t('app', 'Обновлено c IP'),
        ];
    }
}
