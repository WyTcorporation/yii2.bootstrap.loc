<?php

namespace backend\models\blog;

use backend\models\translations\Translations;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property int $active
 * @property string $slug
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 * @property string $name
 * @property int $language_id
 * @property int $type_id
 * @property int $content_id
 *
 * @property Translations $translation
 * @property Translations[] $translations
 */
class Blog extends \yii\db\ActiveRecord
{

    public $name;
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
            [
                //включить intl  в php
                'class' => SluggableBehavior::className(),
                'attribute' => null,
                'slugAttribute' => 'slug',
                //'immutable' => true,//неизменный
                //'ensureUnique'=>true,//генерировать уникальный
                'value' => function ($event) {
                    if (isset($this->owner->slug) && !empty($this->owner->slug)){
                        return $this->owner->slug;
                    }
                    $name =  $this->owner->name;
                    $slugParts = str_replace(' ', '-', $name);
                    $slugParts = mb_convert_encoding ($slugParts, 'UTF-8');
                    $slug = Inflector::slug($slugParts, '-');
                    return $slug;
                }
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'],'string'],
            [['active'],'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('backend/attributes', 'name'),
            'short_content' => Yii::t('backend/attributes', 'short_content'),
            'content' => Yii::t('backend/attributes', 'content'),
            'keywords' => Yii::t('backend/attributes', 'keywords'),
            'description' => Yii::t('backend/attributes', 'description'),
            'slug' => Yii::t('backend/attributes', 'slug'),
            'active' => Yii::t('backend/attributes', 'Publication'),
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
            'type_id' => $this->type_id,
        ]);
    }
}
