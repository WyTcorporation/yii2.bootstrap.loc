<?php

namespace backend\models\translations;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "languages".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $active
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 *
 * @property Translations[] $translations
 */
class Languages extends \yii\db\ActiveRecord
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
        return 'languages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['active'], 'string'],
            [['name', 'code'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
            [['code'], 'match', 'pattern' => '/^[A-zА-я\s]+$/u', 'message' => Yii::t('app', 'Это поле может содержать только строчные буквы')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'active' => 'Active',
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'created_by' => Yii::t('app', 'Создано пользователем'),
            'updated_by' => Yii::t('app', 'Обновлено пользователем'),
            'created_ip' => Yii::t('app', 'Создано c IP'),
            'updated_ip' => Yii::t('app', 'Обновлено c IP'),
        ];
    }

    /**
     * Gets query for [[Translations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translations::className(), ['language_id' => 'id']);
    }
}
