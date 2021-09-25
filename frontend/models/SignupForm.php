<?php
namespace frontend\models;

use Yii;
use yii\base\BaseObject;
use yii\base\Model;
use common\models\User;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $phone;
    public $email;
    public $password;

    public function behaviors()
    {
        return [
            //create_at, update_at
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
            ],
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
    public function rules()
    {
        return [
//            ['phone', 'trim'],
//            ['phone', 'required'],
//            ['phone', 'string', 'max' => 255],
//            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This phone has already been taken.'],
//            ['phone', 'string', 'min' => 2, 'max' => 255],

            ['username', 'trim'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'username' => 'Имя',
            'email' => 'E-Mail',
            'password' => 'Пароль',
        ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->status = 10;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if($user->save()){
            if (isset($this->phone) && !empty($this->phone)) {
                $profile = new UserProfile();
                $profile->user_id = $user->id;
                $profile->phone = $this->phone;
                $profile->firstname = ' ';
                $profile->lastname = ' ';
                $profile->save();
            }
            $this->sendEmail($user);
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('user');
            $auth->assign($role, $user->id);

            return $user;
        }
        return null;

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
