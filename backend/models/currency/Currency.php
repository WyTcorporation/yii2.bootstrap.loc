<?php

namespace backend\models\currency;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property string $code
 * @property float $rate
 * @property string|null $decimal_places
 * @property int|null $is_default
 * @property int|null $sort
 * @property string|null $status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 */
class Currency extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

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
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'symbol', 'code', 'rate'], 'required'],

            [['rate'], 'number'],

            [['is_default', 'sort'], 'integer'],

            [['status'], 'string'],

            [['name', 'symbol'], 'string', 'max' => 32],

            [['decimal_places'], 'string', 'max' => 9],

            [['code'], 'string', 'max' => 3],
            [['code'], 'match', 'pattern' => '/^[A-Z]+$/', 'message' => Yii::t('app', 'Это поле может содержать только строчные буквы, цифры и дефис')],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Код'),
            'name' => Yii::t('app', 'Название'),
            'symbol' => Yii::t('app', 'Символ'),
            'rate' => Yii::t('app', 'Курс'),
            'decimal_places' => Yii::t('app', 'Количество знаков после запятой'),
            'is_default' => Yii::t('app', 'По умолчанию'),
            'sort' => Yii::t('app', 'Сортировка'),
            'status' => Yii::t('app', 'Опубликован'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'created_by' => Yii::t('app', 'Создано пользователем'),
            'updated_by' => Yii::t('app', 'Обновлено пользователем'),
            'created_ip' => Yii::t('app', 'Создано c IP'),
            'updated_ip' => Yii::t('app', 'Обновлено c IP'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        return Yii::$app->session->remove('currency');
    }

    public static function listItems()
    {
        $items = self::find()
            ->select(['code'])
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['sort' => SORT_ASC])
            ->asArray()
            ->all();
        return ArrayHelper::map($items, 'code', 'code');
    }

    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Опубликован'),
            self::STATUS_INACTIVE => Yii::t('app', 'Не опубликован'),
        ];
    }
}
