<?php

namespace backend\models\characteristics;

use backend\models\translations\Translations;
use Yii;

/**
 * This is the model class for table "characteristics_options".
 *
 * @property int $id
 * @property int $characteristics_id
 * @property string $content
 * @property int $language_id
 * @property int $type_id
 * @property int $content_id
 * @property string $name
 * @property array $array
 *
 * @property Translations $translation
 * @property Characteristics $characteristics
 * @property CharacteristicsProducts[] $characteristicsProducts
 */
class CharacteristicsOptions extends \yii\db\ActiveRecord
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
        return 'characteristics_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['characteristics_id'], 'required'],
            [['characteristics_id'], 'integer'],
            [['content'], 'string'],
            [['characteristics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Characteristics::className(), 'targetAttribute' => ['characteristics_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'characteristics_id' => Yii::t('backend', 'Characteristics'),
            'name' => Yii::t('backend', 'Name'),
            'content' => 'content',
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
    /**
     * Gets query for [[Characteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristics()
    {
        return $this->hasOne(Characteristics::className(), ['id' => 'characteristics_id']);
    }

    /**
     * Gets query for [[CharacteristicsProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicsProducts()
    {
        return $this->hasMany(CharacteristicsProducts::className(), ['characteristics_options_id' => 'id']);
    }
}
