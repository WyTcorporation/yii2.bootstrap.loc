<?php

namespace backend\models\products;

use backend\models\categories\Categories;
use backend\models\Category;
use backend\models\characteristics\CharacteristicsProducts;
use backend\models\translations\Translations;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $category_id
 * @property int $models_id
 * @property float $price
 * @property string|null $img
 * @property string|null $gallery
 * @property string $slug
 * @property string $vendor_code
 * @property string|null $currency_code
 * @property string|null $hit
 * @property string|null $new
 * @property string|null $sale
 * @property string|null $active
 * @property int|null $status_stock
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
 * @property ProductsModels $model
 * @property Translations $translation
 * @property CharacteristicsProducts[] $characteristicsProducts
 * @property mixed $category
 * @property ProductsComments[] $productsComments
 */
class Products extends \yii\db\ActiveRecord
{
    public $name;
    public $language_id;
    public $type_id;
    public $content_id;
    public $imageFile;
    public $imageFiles;

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
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'price', 'vendor_code'], 'required'],
            [['category_id', 'models_id', 'status_stock'], 'integer'],
            [['price'], 'number'],
            [['gallery', 'hit', 'new', 'sale', 'active'], 'string'],
            [['img', 'slug', 'vendor_code'], 'string', 'max' => 255],
            [['currency_code'], 'string', 'max' => 3],
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
            'category_id' => Yii::t('backend', 'Categories'),
            'models_id' => Yii::t('backend', 'Products Models'),
            'price' => Yii::t('backend/attributes', 'Price'),
            'img' => Yii::t('backend/attributes', 'img'),
            'gallery' => Yii::t('backend/attributes', 'gallery'),
            'slug' => Yii::t('backend/attributes', 'slug'),
            'vendor_code' => Yii::t('backend/attributes', 'Vendor Code'),
            'currency_code' => Yii::t('backend/attributes', 'Currency Code'),
            'hit' => Yii::t('backend/attributes', 'Hit'),
            'new' => Yii::t('backend/attributes', 'New'),
            'sale' => Yii::t('backend/attributes', 'Sale'),
            'active' => Yii::t('backend/attributes', 'Publication'),
            'status_stock' => Yii::t('backend/attributes', 'Status Stock'),
            'created_at' => Yii::t('backend/attributes', 'date of creation'),
            'updated_at' => Yii::t('backend/attributes', 'Update date'),
            'created_by' => Yii::t('backend/attributes', 'User created'),
            'updated_by' => Yii::t('backend/attributes', 'Updated by user'),
            'created_ip' => Yii::t('backend/attributes', 'Created with IP'),
            'updated_ip' => Yii::t('backend/attributes', 'Updated from IP'),
        ];
    }

    public function getModel()
    {
        return $this->hasOne(ProductsModels::className(), ['id' => 'models_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
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
     * Gets query for [[CharacteristicsProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicsProducts()
    {
        return $this->hasMany(CharacteristicsProducts::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductsComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsComments()
    {
        return $this->hasMany(ProductsComments::className(), ['product_id' => 'id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            //Проверка существует папка или нет
            $dir_name = '../../frontend/web/uploads/';
            if (!file_exists($dir_name)) {
                mkdir($dir_name, 0777, true);
            }
            $save = $this->imageFile->saveAs('@frontend/web/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $path = '/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            return $path;
        } else {
            return false;
        }
    }

    public function uploads()
    {
        if ($this->validate()) {
            $path = [];
            //Проверка существует папка или нет
            $dir_name = '../../frontend/web/uploads/';
            if (!file_exists($dir_name)) {
                mkdir($dir_name, 0777, true);
            }
            foreach ($this->imageFiles as $file) {
                $file->saveAs('@frontend/web/uploads/' . $file->baseName . '.' . $file->extension);
                $path[] = '/uploads/' . $file->baseName . '.' . $file->extension;
            }
            return $path;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if ($file = UploadedFile::getInstance($this, 'imageFile')) {
            $dir = '../../frontend/web/uploads/products/' . date("Y_m_d") . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_name = uniqid() . '_' . $file->baseName . '.' . $file->extension;
            $path = '/uploads/products/' . date("Y_m_d") . '/';
            $this->img = $path . $file_name;
            $file->saveAs($dir . $file_name);

            $watermarkImage = '@backend/web/logo.png';
            $image = '@frontend/web'.$path . $file_name;
            // Store the Image object in a variable
            $newImage = Image::watermark($image, $watermarkImage);
            // Call the save function to write the file to the disk.
            $newImage->save(Yii::getAlias($image));

        }
        if ($files = UploadedFile::getInstances($this, 'imageFiles')) {
            $dir = '../../frontend/web/uploads/products/' . date("Y_m_d") . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $path = '/uploads/products/' . date("Y_m_d") . '/';
            foreach ($files as $file) {
                $file_name = uniqid() . '_' . $file->baseName . '.' . $file->extension;
                $this->img = $path . $file_name;
                $file->saveAs($dir . $file_name);
                $new_path[] = $this->img;

                $watermarkImage = '@backend/web/logo.png';
                $image = '@frontend/web'.$path . $file_name;
                // Store the Image object in a variable
                $newImage = Image::watermark($image, $watermarkImage);
                // Call the save function to write the file to the disk.
                $newImage->save(Yii::getAlias($image));
            }
            $this->gallery = serialize($new_path);

        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
