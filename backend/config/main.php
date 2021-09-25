<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => $params['sourceLanguage'],
    'sourceLanguage' => $params['sourceLanguage'],
//    'layout' => 'admin',
    'modules' => [
        'api' => [
            //http://yii2.shop.loc/admin/api/v1/statistics
            'class' => 'backend\modules\api\Api',
        ],
//        'v1' => [
//            //http://yii2.shop.loc/admin/v1/statistics
//            'class' => 'backend\modules\api\modules\v1\VersionOne',
//        ],
    ],
    'components' => [
        //Форматируем дату по всему сайту
//        'formatter'=>[
//            'datetimeFormat' => 'php:d F H:i:s'
//        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            //Если надо перенаправить на другую страницу авторизации
//            'loginUrl' => '/admin/auth/login',
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.ukr.net',
                'username' => 'yii2_loc@ukr.net',
                'password' => 'password',
                'port' => '2525', // 465
                'encryption' => 'ssl', // tls
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'calculatores' => 'site/calculator',
                'order/<id:\d+>' => 'order/view',

                'category/<id:\d+>/page/<page:\d+>' => 'category/view',
                'category/<id:\d+>' => 'category/view',
                'product/<id:\d+>' => 'product/view',


                [
                    //Пример
                    //GET http://yii2.shop.loc/admin/api/v1/statistics
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['api/v1/statistics'],
                    'extraPatterns' => [
                        'GET /' => 'index',
                    ],
                ],
                [
                    //Пример
                    //GET http://yii2.shop.loc/admin/api/v1/search-options
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['api/v1/search-options'],
                    'extraPatterns' => [
                        'GET /' => 'index',
                    ],
                ],
                [
                    //Пример
                    //POST http://yii2.shop.loc/admin/api/v1/call-back
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['api/v1/call-back'],
                    'extraPatterns' => [
                        'POST /' => 'index',
                        'POST /search' => 'search',
                    ],
                ],
                [
                    //Пример
                    //POST http://yii2.shop.loc/admin/api/v1/nova-poshta-api-list
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['api/v1/nova-poshta-api-list'],
                    'extraPatterns' => [
                        'POST /cities' => 'cities',
                        'POST /regions' => 'regions',
                        'POST /warehouses' => 'warehouses',
                    ],
                ],
                [
                    //Пример
                    //POST http://yii2.shop.loc/admin/api/v1/currency
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['api/v1/currency'],
                    'extraPatterns' => [
                        'POST /' => 'index',
                    ],
                ],
                [
                    //Пример
                    //GET http://yii2.shop.loc/admin/api/v1/users
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['api/v1/users'],
                    'extraPatterns' => [
                        'GET /' => 'index',
                    ],
                ],
                [
                    //Пример
                    //GET http://yii2.shop.loc/admin/api/v1/products
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['api/v1/products'],
                    'extraPatterns' => [
                        'GET /' => 'index',
                        'GET /get-product' => 'get-product',
                    ],
                ]
            ],
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'baseUrl' => '/uploads',
                'basePath' => '@frontend/web/uploads',
                'name' => 'Uploads'
            ],
            'watermark' => [
                'source' => __DIR__ . '/logo.png', // Path to Water mark image
                'marginRight' => 5,          // Margin right pixel
                'marginBottom' => 5,          // Margin bottom pixel
                'quality' => 95,         // JPEG image save quality
                'transparency' => 70,         // Water mark image transparency ( other than PNG )
                'targetType' => IMG_GIF | IMG_JPG | IMG_PNG | IMG_WBMP, // Target image formats ( bit-field )
                'targetMinPixel' => 200         // Target image minimum pixel size
            ]
        ]
    ],
    'params' => $params,
];
