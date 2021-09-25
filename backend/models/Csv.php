<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 21.03.2020
 * Time: 17:02
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace backend\models;

use yii\db\ActiveRecord;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property string $imageFile
 */
class Csv extends ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'products';
    }

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Файл',
        ];
    }

    public function upload($name = null)
    {
        if ($this->validate()) {
            if(isset($name)) {
                $dir = '../../backend/web/uploads/' . date("Y_m_d") . '/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $file_name = uniqid() . '_' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
                $path = '/uploads/' . date("Y_m_d") . '/'.$file_name;
                $this->imageFile->saveAs($dir . $file_name);
                return $path;
            }

//            $this->imageFile->saveAs('@backend/web/akb.' . $this->imageFile->extension);

            $dir = '../../backend/web/uploads/' . date("Y_m_d") . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_name = uniqid() . '_akb.' . $this->imageFile->extension;
            $path = '/uploads/' . date("Y_m_d") . '/'.$file_name;
            $this->imageFile->saveAs($dir . $file_name);
            return $path;
        } else {
            return false;
        }
    }
}
