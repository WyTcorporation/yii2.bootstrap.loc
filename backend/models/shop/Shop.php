<?php

namespace backend\models\shop;

use backend\models\translations\Translations;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "shop".
 *
 * @property int $id
 * @property string|null $address
 * @property string|null $phones
 * @property string|null $location
 * @property string|null $date
 * @property string|null $email
 * @property int $created_at
 * @property int|null $updated_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property string $created_ip
 * @property string|null $updated_ip
 * @property string $name
 * @property array $array
 * @property int $language_id
 * @property int $type_id
 * @property int $content_id
 */
class Shop extends \yii\db\ActiveRecord
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
        return 'shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'phones', 'location','date','email'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'phones' => 'Phones',
            'location' => 'Location',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_ip' => 'Created Ip',
            'updated_ip' => 'Updated Ip',
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
