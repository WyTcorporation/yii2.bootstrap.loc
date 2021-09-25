<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 10.09.2021
 * Time: 06:31
 * User: WyTcorporation
 */
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Currency extends ActiveRecord
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

    public static function tableName()
    {
        return 'currency';
    }

    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['is_default', 'sort', 'status'], 'integer'],
            [['decimal_places'], 'integer', 'max' => 9],
            [['rate'], 'number'],
            [['code'], 'string', 'length' => 3],
            [['code'], 'unique'],
            [['code'], 'match', 'pattern' => '/^[A-Z]+$/', 'message' => Yii::t('app', 'Это поле может содержать только строчные буквы, цифры и дефис')],
            [['name', 'symbol'], 'string', 'max' => 32],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('backend/attributes', 'date of creation'),
            'updated_at' => Yii::t('backend/attributes', 'Update date'),
            'created_by' => Yii::t('backend/attributes', 'User created'),
            'updated_by' => Yii::t('backend/attributes', 'Updated by user'),
            'created_ip' => Yii::t('backend/attributes', 'Created with IP'),
            'updated_ip' => Yii::t('backend/attributes', 'Updated from IP'),
            'code' => Yii::t('app', 'Код'),
            'name' => Yii::t('app', 'Название'),
            'symbol' => Yii::t('app', 'Символ'),
            'rate' => Yii::t('app', 'Курс'),
            'decimal_places' => Yii::t('app', 'Количество знаков после запятой'),
            'is_default' => Yii::t('app', 'По умолчанию'),
            'sort' => Yii::t('app', 'Сортировка'),
            'status' => Yii::t('app', 'Опубликован'),
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


