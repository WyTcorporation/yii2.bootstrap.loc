<?php

namespace backend\models\translations;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "translations".
 *
 * @property int $id
 * @property int $language_id
 * @property int $translation_id
 * @property int $type_id
 * @property int $content_id
 * @property string $content
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 *
 * @property Content $content0
 * @property Type $type
 * @property Languages $language
 */
class Translations extends \yii\db\ActiveRecord
{
    public $field_name;
    public $field_content;
    public $field_short_content;
    public $field_keywords;
    public $field_description;

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
        return 'translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language_id', 'translation_id', 'type_id', 'content_id', 'content'], 'required'],
            [['language_id', 'translation_id', 'type_id', 'content_id'], 'integer'],
            [['content'], 'string'],
            [['content'], 'trim'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language_id' => 'Language ID',
            'translation_id' => 'Translation ID',
            'type_id' => 'Type ID',
            'content_id' => 'Content ID',
            'content' => 'Content',
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'created_by' => Yii::t('app', 'Создано пользователем'),
            'updated_by' => Yii::t('app', 'Обновлено пользователем'),
            'created_ip' => Yii::t('app', 'Создано c IP'),
            'updated_ip' => Yii::t('app', 'Обновлено c IP'),
        ];
    }

    /**
     * Gets query for [[Content0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContent0All()
    {
        return Content::find()->all();
    }

    public function getContent0()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }
    public function getTypeBy($type)
    {
        return Type::findOne(['type' => $type]);
    }
    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getLanguageBy($code)
    {
        return Languages::findOne(['code' => $code]);
    }

    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'language_id']);
    }
}
