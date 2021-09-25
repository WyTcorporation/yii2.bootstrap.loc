<?php

namespace backend\models\message;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int|null $from
 * @property int|null $to
 * @property string|null $text
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 */
//https://www.pvsm.ru/ajax/191782
class Message extends \yii\db\ActiveRecord
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
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'to'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'to' => 'To',
            'text' => 'Text',
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'created_by' => Yii::t('app', 'Создано пользователем'),
            'updated_by' => Yii::t('app', 'Обновлено пользователем'),
            'created_ip' => Yii::t('app', 'Создано c IP'),
            'updated_ip' => Yii::t('app', 'Обновлено c IP'),
        ];
    }

    /**
     * @param int $from
     * @param int $to
     * @return ActiveQuery
     */
    public static function findMessages($from, $to)
    {
        return self::find()
            ->where(['from' => $from])
            ->orWhere(['from' => $to, 'to' => $from]);
    }

}
