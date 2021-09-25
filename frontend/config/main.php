<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'languages',
    ],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru-Ru',
//меняя языки не забывать менять доступ бд и в модальном окне карточки + Бек Options
    'sourceLanguage' => $params['sourceLanguage'],
    'defaultRoute' => 'category/index',
    'modules' => [
        'languages' => [
            'class' => 'common\modules\languages\Module',
            //Языки используемые в приложении
            'languages' => $params['languages'],
            'default_language' => $params['sourceLanguage'], //основной язык (по-умолчанию)
            'show_default' => false, //true - показывать в URL основной язык, false - нет
        ],
        'redactor' => 'yii\redactor\RedactorModule',
        'class' => 'yii\redactor\RedactorModule',
        'uploadDir' => '@webroot/uploads',
        'uploadUrl' => '/hello/uploads',
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => TRUE,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin']
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'class' => 'common\components\Request'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'linkAssets' => false,//???
            'forceCopy' => true
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //Включить что бы правильно работали урлы мультиязычности (Но после этого debug панель не работает)
            //'class' => 'common\components\UrlManager',
            'rules' => [
                'languages' => 'languages/default/index',
                'news' => 'site/index',
                'news/<slug>' => 'site/news',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'signup' => 'site/signup',
                'wishlist' => 'wishlist/view',
                'cart' => 'cart/view',
                'profile' => 'profile/index',
                'contacts' => 'site/contact',
                //Убираею гет параметр пагинации (Должен быть выше основного)
//                'category/<id:\d+>/page/<page:\d+>' => 'category/view',
//                'category/<id:\d+>' => 'category/view',
                'category/<slug>/page/<page:\d+>' => 'category/view',
                'category/<slug>' => 'category/view',
                'search' => 'category/search',
                'new' => 'product/new',
                'sale' => 'product/sale',
                'product/<slug>' => 'product/view',
                '<slug>' => 'pages/index',
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => $params['google_client_id'],
                    'clientSecret' => $params['google_client_secret'],
                    'returnUrl' => 'https://yii2.shop.ua/site/auth?authclient=google'
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => $params['facebook_client_id'],
                    'clientSecret' => $params['facebook_client_secret'],
                    'returnUrl' => 'https://yii2.shop.ua/site/auth?authclient=facebook'
                ],
//                'github' => [
//                    'class' => 'yii\authclient\clients\GitHub',
//                    'clientId' => 'facebook_client_id',
//                    'clientSecret' => 'facebook_client_secret',
//                ],
//                'linkedin' => [
//                    'class' => 'yii\authclient\clients\LinkedIn',
//                    'clientId' => 'facebook_client_id',
//                    'clientSecret' => 'facebook_client_secret',
//                ],
//                'twitter' => [
//                    'class' => 'yii\authclient\clients\Twitter',
//                    'clientId' => 'facebook_client_id',
//                    'clientSecret' => 'facebook_client_secret',
//                ],
            ],
        ]
    ],
    'params' => $params,
];
