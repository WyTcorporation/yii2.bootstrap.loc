<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 07.09.2021
 * Time: 19:54
 * User: WyTcorporation
 */

namespace frontend\controllers;


use backend\models\user\UserAddress;
use backend\models\user\UserProfile;
use common\models\User;
use Yii;

use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ProfileController extends AppController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['password','index','contact','login','logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','contact','password','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],

            ],
//            $this->isAdmin(['index']),
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        $this->setMeta(null, null, null, 'Личный Кабинет');

        $user = Yii::$app->user;

        return $this->render('index',compact('user'));
    }

    public function actionContact($id)
    {

        $this->setMeta(null, null, null, 'Личный Кабинет');

        $user = User::findOne($id);

        $profile = UserProfile::findOne(['user_id'=>$id]);

        if (!isset($profile) && empty($profile)) {
            $profile = new UserProfile();
        }

        if ($profile->load(Yii::$app->request->post())) {
            $profile->save();

            $user->save();

            Yii::$app->session->setFlash('success', Yii::t('frontend/flash', 'Thanks! Data updated'));
            
            return $this->redirect('index');
        }
        return $this->render('contact',compact('user','profile'));
    }

    public function actionPassword($id)
    {

        $this->setMeta(null, null, null, 'Изменить пароль');

        $user = User::findOne($id);

        $user->scenario = User::SCENARIO_CREATE;

        if ($user->load(Yii::$app->request->post())) {

            $user->setPassword($user->password);
            $user->save();

            Yii::$app->session->setFlash('success', Yii::t('frontend/flash', 'Thanks! Data updated'));

            return $this->redirect('index');
        }

        return $this->render('password',compact('user'));
    }

    public function actionAddress($id)
    {

        $this->setMeta(null, null, null, 'Адресная книга');

        $user = User::findOne($id);

        $address = UserAddress::findOne(['user_id'=>$id]);

        if (!isset($address) && empty($address)) {
            $address = new UserAddress();
        }

        if ($address->load(Yii::$app->request->post()) && $address->save()) {

            Yii::$app->session->setFlash('success', Yii::t('frontend/flash', 'Thanks! Data updated'));

            return $this->redirect('index');
        }

        return $this->render('address',compact('user','address'));
    }
}