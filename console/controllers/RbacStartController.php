<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 27.08.2021
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacStartController extends Controller
{
    //php yii rbac-start/init
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные

        //Создадим для примера права для доступа к админке
        $dashboard = $auth->createPermission('adminPanel');
        $dashboard->description = 'Админ панель';
        $auth->add($dashboard);

        //Добавляем роли
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);

        $moder = $auth->createRole('moder');
        $moder->description = 'Модератор';
        $auth->add($moder);

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);

        $superAdmin = $auth->createRole('superAdmin');
        $superAdmin->description = 'Разработчик';
        $auth->add($superAdmin);

        //Добавляем потомков
        $auth->addChild($moder, $user);
        $auth->addChild($moder, $dashboard);
        $auth->addChild($admin, $moder);
        $auth->addChild($superAdmin, $admin);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($superAdmin, 1);

        // Назначаем роль moder пользователю с ID 2
        $auth->assign($admin, 2);
        // Назначаем роль moder пользователю с ID 3
        $auth->assign($moder, 3);
    }

}