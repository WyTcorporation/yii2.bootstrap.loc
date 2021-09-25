<?php
return [
    'name'=> 'LockIt',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'frontend/cart' => 'cart.php',
                        'frontend/buttons' => 'buttons.php',
                        'frontend/links' => 'links.php',
                        'frontend/flash' => 'flash.php',
                        'frontend' => 'frontend.php',
                    ],
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'backend/flash' => 'flash.php',
                        'backend/attributes' => 'attributes.php',
                        'backend/buttons' => 'buttons.php',
                        'backend/links' => 'links.php',
                        'backend' => 'backend.php',
                    ],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
