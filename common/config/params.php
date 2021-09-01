<?php

return [
    require_once(__DIR__ . '/../../common/config/functions.php'),
    require_once(__DIR__ . '/../../common/config/languages.php'),
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'bsDependencyEnabled' => false,
    'sourceLanguage' => 'ru',
    'shopTitle' => 'Магазин | ',
    'languages' => get_languages(),
    'AccessControlRulesClose' => [
        'adminPanel',
        'calculator',
        'languages',
        'yandex',
        'yandex-news',
        'yandex-news-list',
        'video',
        'category',
        'product',
        'search-session',
        'size',
        'logout',
        'login',
        'error',
        '_form',
        '_search',
        'create',
        'index',
        'update',
        'view'
    ],
    'AccessControlRulesOpen' => [
        'logout',
        'login',
        'error',
    ],
];

