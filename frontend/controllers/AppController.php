<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 19:08
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class AppController extends Controller
{
    protected function setMeta($title = null, $keywords = null, $description = null, $forceTitle = null)
    {
        $paramsLanguages = $this->getParamsLanguages();

        $title = unserialize($title)[$paramsLanguages['language']];
        $keywords = unserialize($keywords)[$paramsLanguages['language']];
        $description = unserialize($description)[$paramsLanguages['language']];
        $shopTitle = Yii::$app->params['shopTitle'];

        if (isset($forceTitle) && !empty($forceTitle)) {
            $this->view->title = $forceTitle;
        } else {
            $this->view->title = $shopTitle . $title;
        }

        $this->view->registerMetaTag(['name' => 'keywords', 'contents' => "$keywords"]);
        $this->view->registerMetaTag(['name' => 'description', 'contents' => "$description"]);
    }

    public function getParamsLanguages()
    {
        $params = Yii::$app->params['languages'];
        $language = Yii::$app->language;

        return ['params' => $params, 'language' => $language];
    }

    public function isAdmin($actions)
    {
        //Пример
//        $actions = ['index'];
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
    }

    public function userCanExample()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = \Yii::$app->user->getId();

            //Все роли текущего пользователя
            var_dump(\Yii::$app->authManager->getRolesByUser($userId));
            PHP_EOL;

            //Разрешение пользователя
            var_dump(\Yii::$app->authManager->getAssignment('admin', $userId));
            PHP_EOL;

            //Все разрешения пользователя
            var_dump(\Yii::$app->authManager->getAssignments($userId));
            PHP_EOL;

            //Проверка доступа пользователя
            var_dump(\Yii::$app->authManager->checkAccess($userId, 'admin', $params = []));
            PHP_EOL;

            //Тоже проверка доступа пользователя
            var_dump(Yii::$app->user->can('admin'));

            if (Yii::$app->user->can('admin')) {
                echo "Привет, админ!" . PHP_EOL;
            }

            //Аналогично работает с вариантом выше
            if (\Yii::$app->authManager->checkAccess($userId, 'admin', $params = [])) {
                echo "Привет, админ!" . PHP_EOL;
            }

        } else {
            echo "Здравствуйте, Гость!";
        }
    }
}
