<?php

namespace backend\models\categories;

use backend\models\products\Products;
use backend\models\translations\Translations;
use frontend\models\Category;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $slug
 * @property string|null $img
 * @property string|null $gallery
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
 * @property Products[] $products
 * @property Categories $category
 * @property CategoriesCharacteristics[] $categoriesCharacteristics
 * @property CategoriesPercent[] $categoriesPercents
 */
class Categories extends \yii\db\ActiveRecord
{
    public $name;
    public $childs;
    public $imageFile;
    public $imageFiles;
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
                    $name = $this->owner->name;
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
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['gallery'], 'string'],
            [['slug', 'img',], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxFiles' => 10],
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
            'percents' => Yii::t('backend/attributes', 'percents'),
            'parent_id' => Yii::t('backend/attributes', 'parent_id'),
            'characteristics' => Yii::t('backend/attributes', 'characteristics'),
            'slug' => Yii::t('backend/attributes', 'slug'),
            'imageFile' => Yii::t('backend/attributes', 'imageFile'),
            'imageFiles' => Yii::t('backend/attributes', 'imageFiles'),
            'img' => Yii::t('backend/attributes', 'img'),
            'gallery' => Yii::t('backend/attributes', 'gallery'),
            'created_at' => Yii::t('backend/attributes', 'date of creation'),
            'updated_at' => Yii::t('backend/attributes', 'Update date'),
            'created_by' => Yii::t('backend/attributes', 'User created'),
            'updated_by' => Yii::t('backend/attributes', 'Updated by user'),
            'created_ip' => Yii::t('backend/attributes', 'Created with IP'),
            'updated_ip' => Yii::t('backend/attributes', 'Updated from IP'),
        ];
    }

    public function getProducts(){
        return $this->hasMany(Products::className(),['category_id'=>'id']);
    }

    public function getCategory() {
        return $this->hasOne(Categories::className(),['id'=>'parent_id']);
    }

    public function getTranslation()
    {
        return $this->hasOne(Translations::className(), ['translation_id' => 'id'])->andOnCondition([
            'language_id' => $this->language_id,
            'type_id' => $this->type_id,
            'content_id' => $this->content_id,
        ]);
    }
    /**
     * Gets query for [[CategoriesCharacteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesCharacteristics()
    {
        return $this->hasMany(CategoriesCharacteristics::className(), ['categories_id' => 'id']);
    }

    /**
     * Gets query for [[CategoriesPercents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesPercents()
    {
        return $this->hasMany(CategoriesPercent::className(), ['categories_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if ($file = UploadedFile::getInstance($this, 'imageFile')) {
            $dir = '../../frontend/web/uploads/category/' . date("Y_m_d") . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_name = uniqid() . '_' . $file->baseName . '.' . $file->extension;
            $path = '/uploads/category/' . date("Y_m_d") . '/';
            $this->img = $path . $file_name;
            $file->saveAs($dir . $file_name);

        }
        if ($files = UploadedFile::getInstances($this, 'imageFiles')) {
            $dir = '../../frontend/web/uploads/category/' . date("Y_m_d") . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $path = '/uploads/category/' . date("Y_m_d") . '/';
            foreach ($files as $file) {
                $file_name = uniqid() . '_' . $file->baseName . '.' . $file->extension;
                $this->img = $path . $file_name;
                $file->saveAs($dir . $file_name);
                $new_path[] = $this->img;
            }
            $this->gallery = serialize($new_path);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
