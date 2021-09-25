<?php

namespace frontend\controllers;

use backend\models\blog\Blog;
use backend\models\shop\Shop;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Type;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\components\AuthHandler;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        //Params
        $language = Yii::$app->language;
        $params = Yii::$app->params['languages'];
        $language_id = Languages::findOne(['code' => $language])->id;
        $content = Content::find()->asArray()->all();
        $type = Type::find()->asArray()->all();

        if (isset($content) && !empty($content)) {
            for ($x = 0; $x <= count($type); $x++) {
                if ($content[$x]['content'] == 'name') $content_name_id = (int)$content[$x]['id'];
                if ($content[$x]['content'] == 'short_content') $content_short_content_id = (int)$content[$x]['id'];
            }
        }

        if (isset($type) && !empty($type)) {
            for ($x = 0; $x <= count($type); $x++) {
                if ($type[$x]['type'] == 'blog') $type_blog_id = (int)$type[$x]['id'];
            }
        }

        $query = Blog::find()->where(['active' => 1]);

        $pageSize = 16;

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => $pageSize, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $news = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $shopTitle = Yii::$app->params['shopTitle'];

        $this->setMeta(null, null, null,$shopTitle.'Новости');


        $array = [];
        for ($x = 0; $x <= count($news); $x++){
            if (isset($news[$x]) && !empty($news[$x])){
                $array[$x]['slug'] = $news[$x]->slug;
                $news[$x]->language_id = $language_id;
                $news[$x]->type_id = $type_blog_id;
                $translations = $news[$x]->translations;

                for ($y = 0; $y <= count($translations); $y++){
                    if ($translations[$y]->content_id == $content_name_id) {
                        $array[$x]['name'] = $translations[$y]->content;
                    }
                    if ( $translations[$y]->content_id == $content_short_content_id) {
                        $array[$x]['short_content'] = $translations[$y]->content;
                    }
                }

            }
        }

        return $this->render('index',[
            'news'=>$array,
            'pages'=>$pages,
            'language_id'=>$language_id,
            'content_name_id'=>$content_name_id,
            'content_short_content_id'=>$content_short_content_id,
            'type_blog_id'=>$type_blog_id,
        ]);
    }

    public function actionNews($slug)
    {

        //Params
        $language = Yii::$app->language;
        $params = Yii::$app->params['languages'];
        $language_id = Languages::findOne(['code' => $language])->id;
        $content = Content::find()->asArray()->all();
        $type = Type::find()->asArray()->all();

        if (isset($content) && !empty($content)) {
            for ($x = 0; $x <= count($type); $x++) {
                if ($content[$x]['content'] == 'name') $content_name_id = (int)$content[$x]['id'];
                if ($content[$x]['content'] == 'short_content') $content_short_content_id = (int)$content[$x]['id'];
            }
        }

        if (isset($type) && !empty($type)) {
            for ($x = 0; $x <= count($type); $x++) {
                if ($type[$x]['type'] == 'blog') $type_blog_id = (int)$type[$x]['id'];
            }
        }

        $news = Blog::findOne(['slug'=>$slug]);
        if (empty($news)) {
            throw new HttpException(404, Yii::t('frontend/flash', 'There is no such news'));
        }

        $translations = $this->getTranslationsList($news->id, 'blog');

        $this->setMeta($translations[$language]['name']->content, $translations[$language]['keywords']->content, $translations[$language]['description']->content);

        return $this->render('news',[
            'language'=>$language,
            'translations'=>$translations,
        ]);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->setMeta(null, null, null);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $language = Yii::$app->language;
        $model = Shop::findOne(1);
        if (isset($model) && !empty($model)) {
            $shopTranslations = $this->getTranslationsList($model->id, 'shop');


            $dates = [
                0 => 'пн',
                1 => 'вт',
                2 => 'ср',
                3 => 'чт',
                4 => 'пт',
                5 => 'сб',
                6 => 'вс',
            ];
            $week = [];
            $array = unserialize($model->date);
            $x = 0;

            foreach ($dates as $key => $date) {
                if ($key == 0) {
                    $week[$date] .= $array[$key] . ' ';
                    $week[$date] .= $array[$key + 1] . ' ';
                    $week[$date] .= '<br>';
                } else {
                    if ($array[$key + $x] != '') {
                        $week[$date] .= $array[$key + $x] . ' ';
                        $week[$date] .= $array[$key + $x + 1] . ' ';
                        $week[$date] .= '<br>';
                    } else {
                        $week[$date] .= ' - '.Yii::t('frontend', 'day off').' - <br>';
                    }
                }
                $x++;
            }

            $shops[] = [
                'name' => $shopTranslations[$language]['name']->content,
                'phones' => unserialize($model->phones),
                'address' => $model->address,
                'location' => $model->location,
                'email' => $model->email,
                'date' => $week,
            ];
        }
        $this->setMeta(null, null, null, 'Контакты');
        return $this->render('contact', [
            'shops' => $shops,
        ]);

    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        $this->setMeta(null, null, null);

        if ($model->load(Yii::$app->request->post())) {
            $model->phone = Yii::$app->request->post('SignupForm')['phone'];
            $model->signup();

            Yii::$app->session->setFlash('success', Yii::t('frontend/flash', 'Thank you for registering. Check your email for confirmation'));

            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {

                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
