<?php

namespace backend\models\shop;

use backend\models\translations\Translations;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "stock".
 *
 * @property int $id
 * @property string|null $banner
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

 * @property Translations $translation
 */


class Stock extends \yii\db\ActiveRecord
{
    public $name;
    public $language_id;
    public $type_id;
    public $content_id;
    public $imageFile;

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
        return 'stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['banner'], 'string'],
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
            'banner' => Yii::t('backend/attributes', 'img'),
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

    public function beforeSave($insert)
    {
        if ($file = UploadedFile::getInstance($this, 'imageFile')) {
            $dir = '../../frontend/web/uploads/products/' . date("Y_m_d") . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_name = uniqid() . '_' . $file->baseName . '.' . $file->extension;
            $path = '/uploads/products/' . date("Y_m_d") . '/';
            $result = $file->saveAs($dir . $file_name);

            if ($result) {
                $this->banner = $path . $file_name;
//                $watermarkImage = '@backend/web/logo.png';
//                $image = '@frontend/web'.$path . $file_name;
//                // Store the Image object in a variable
//                $newImage = Image::watermark($image, $watermarkImage);
//                // Call the save function to write the file to the disk.
//                $result = $newImage->save(Yii::getAlias($image));
            }

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
            $this->banner = serialize($new_path);

        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
