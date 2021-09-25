<?php

namespace backend\models\translations;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property string $content
 *
 * @property Translations[] $translations
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[Translations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translations::className(), ['content_id' => 'id']);
    }
}
