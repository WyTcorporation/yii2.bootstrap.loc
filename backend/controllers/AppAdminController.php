<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 19.03.2020
 * Time: 11:07
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace backend\controllers;

use Yii;
//use yii\filters\AccessControl;
use yii2mod\rbac\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AppAdminController extends Controller
{

    public function behaviors()
    {

        $user = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        if ($user['user']->name == 'user') {
            $this->redirect('/');
        }

        $moder = $this->isModerActive()  ?  $this->isModerActive() : null;

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => Yii::$app->params['AccessControlRulesClose'],
                'rules' => [
                    [
                        'actions' => Yii::$app->params['AccessControlRulesOpen'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => Yii::$app->params['AccessControlRulesClose'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    //Достп модератору
                    isset($moder) && !empty($moder) ? $moder : null,
                    [
                        'actions' => Yii::$app->params['AccessControlRulesOpen'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function isModer($actions)
    {
        //Доступ только для модератора
        $actions[] = 'adminPanel';
        $actions[] = 'logout';
        return [
            'actions' => $actions,
            'allow' => true,
            'roles' => ['moder'],
        ];
    }

    public function isAdmin($actions)
    {
        $actions[] = 'adminPanel';
        $actions[] = 'logout';
        //Доступ только для админа
        return [
            'class' => AccessControl::className(),
            'only' => ['index'],
            'rules' => [
                [
                    'actions' => $actions,
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ];

//        //Сначала сохраним authManager в переменную, чтобы код был короче
//        $auth = Yii::$app->authManager;
//
//        //----------------- Создание роли
//
//        //Создадим роль 'author'
//        $author = $auth->createRole('author');
//
//        //Не обязательно, но можно добавить описание роли
//        $author->description = 'Роль автора';
//
//        //Сохраняем роль в базе данных
//        $auth->add($author);
//
//        //-------------------Создание разрешения для создания поста
//
//        $permCreatePost = $auth->createPermission('perm_create-post');//создали объект
//        $permCreatePost->description = 'Разрешение для создания поста';//добавили описание
//        $auth->add($permCreatePost);//создали запись в базе данных
//
//        //-------------------Привяжем разрешение к роли
//        //Роль - это родительский элемент. Разрешение дочерний элемент роли
//        $auth->addChild($author, $permCreatePost);
//
//
//        //-------------------Роль и разрешение созданы. Посмотрим как этим пользоваться.
//
//        //Для начала назначим какому-то обстрактному пользователю с id=10 роль 'автор'
//        $auth->assign($author, 10);
//
//        //Проверим разрешение и если оно есть, позволим создать пост в блоге
//        //Так как разрешение 'perm_create-post' ранее было присоеденино к роли 'author',то
//        //пользователь с id=10 сможет создать пост
//        if(\Yii::$app->user->can('perm_create-post')){
//            //Выводим форму для создания поста блога
//        }
//
//        //Сделаем то же самое, но через метод authManager напрямую
//        $userId = \Yii::$app->getUser();
//        if(\Yii::$app->authManager->checkAccess($userId, 'perm_create-post', $params = [])){
//            //Выводим форму для создания поста блога
//        }
    }

    public function getParamsLanguages()
    {
        $params = Yii::$app->params['languages'];
        $language = Yii::$app->sourceLanguage;

        return ['params' => $params, 'language' => $language];
    }
}
