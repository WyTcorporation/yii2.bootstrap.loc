<?php

namespace backend\models\characteristics;

use backend\models\categories\CategoriesCharacteristics;
use backend\models\translations\Translations;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\db\Transaction;
use yii\helpers\Inflector;

/**
 * This is the model class for table "characteristics".
 *
 * @property int $id
 * @property string|null $filter_status
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 * @property int $language_id
 * @property int $type_id
 * @property int $content_id
 * @property string $name
 * @property array $array
 *
 * @property Translations $translation
 * @property Translations[] $translations
 * @property Translations[] $translationsList
 * @property CategoriesCharacteristics[] $categoriesCharacteristics
 * @property CharacteristicsOptions[] $characteristicsOptions
 */
class Characteristics extends \yii\db\ActiveRecord
{
    public $name;
    public $array;
    public $language_id;
    public $type_id;
    public $content_id;

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
        return 'characteristics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filter_status'], 'required'],
            [['filter_status'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'array' => Yii::t('backend/attributes', 'name'),
            'filter_status' => Yii::t('backend/attributes', 'Filter'),
            'created_at' => Yii::t('backend/attributes', 'date of creation'),
            'updated_at' => Yii::t('backend/attributes', 'Update date'),
            'created_by' => Yii::t('backend/attributes', 'User created'),
            'updated_by' => Yii::t('backend/attributes', 'Updated by user'),
            'created_ip' => Yii::t('backend/attributes', 'Created with IP'),
            'updated_ip' => Yii::t('backend/attributes', 'Updated from IP'),
        ];
    }

    public function getTranslation()
    {
        return $this->hasOne(Translations::className(), ['translation_id' => 'id'])->andOnCondition([
            'language_id' => $this->language_id,
            'type_id' => $this->type_id,
            'content_id' => $this->content_id,
        ]);
    }
    public function getTranslations()
    {
        return $this->hasMany(Translations::className(), ['translation_id' => 'id'])->andOnCondition([
            'language_id' => $this->language_id,
            'type_id' => $this->type_id
        ]);
    }

    public function getTranslationsList()
    {
        return $this->hasMany(Translations::className(), ['translation_id' => 'id'])->andOnCondition([
            'type_id' => $this->type_id
        ]);
    }

    /**
     * Gets query for [[CategoriesCharacteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesCharacteristics()
    {
        return $this->hasMany(CategoriesCharacteristics::className(), ['characteristics_id' => 'id']);
    }

    /**
     * Gets query for [[CharacteristicsOptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicsOptions()
    {
        return $this->hasMany(CharacteristicsOptions::className(), ['characteristics_id' => 'id']);
    }


}
