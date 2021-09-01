<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            //'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'aliases' => [
        //'@api' => dirname(dirname(__DIR__)) . '/api',
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    //Пример
                    //GET http://yii2.shop.loc/api/web/v1/countries
                    //GET http://yii2.shop.loc/api/web/v1/countries/new
                    //GET http://yii2.shop.loc/api/web/v1/countries/new2
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['v1/country'],
//                    'tokens' => [
//                        '{id}' => '<id:\\w+>'
//                    ],
                    'extraPatterns' => [
                        'GET /' => 'index',
                        'GET new' => 'new',
                        'GET new2' => 'new2',
                    ],
//                    'extraPatterns' => [
//                        'POST {id}/your_preferred_url' => 'xxxxx', // 'xxxxx' refers to 'actionXxxxx'
//                    ],
                ],

                [
                    //Пример
                    //GET http://yii2.shop.loc/api/web/v1/countries
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['v1/test'],
                    'extraPatterns' => [
                        'GET /' => 'index',
                    ],
                ]
            ],
        ]
    ],
    'params' => $params,
];



