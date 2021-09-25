<?php

namespace backend\models\products;

use backend\models\translations\Translations;
use Yii;

/**
 * This is the model class for table "products_models".
 *
 * @property int $id
 * @property string|null $active
 * @property int $language_id
 * @property int $type_id
 * @property int $content_id
 * @property string $name
 * @property array $array
 *
 * @property Translations $translation
 */
class ProductsModels extends \yii\db\ActiveRecord
{
    public $name;
    public $array;
    public $language_id;
    public $type_id;
    public $content_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_models';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active'], 'required'],
            [['active'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('backend', 'Name'),
            'active' => Yii::t('backend', 'Publication'),
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
}
