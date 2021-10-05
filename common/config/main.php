<?php
return [
    'name' => 'onlinedars.uz',
    'timeZone' => 'Asia/Tashkent',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@homeUrl' => '/',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'uz',
    'components' => [

        'acf' => [
            'class' => 'backend\modules\acf\components\Acf',
            'fileBasePath' => '@frontend/web/uploads/acf',
            'fileBaseUrl' => '/uploads/acf',
        ],

        'settings' => [
            'class' => 'backend\modules\settings\components\Settings',
            'cache' => null
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'sms' => [
            'class' => 'backend\modules\smsmanager\models\Sms',
        ],
        'formatter' => [
            'class' => 'soft\i18n\SFormatter',
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyCode' => 'UZS',
            'timeZone' => 'Asia/Tashkent',
        ],
        'site' => [
            'class' => 'soft\components\Site',
        ],

        'help' => [
            'class' => 'soft\components\Helper',
        ],
        'admin' => [
            'class' => 'backend\components\Admin',
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '1724508529:AAFMH3X9UhuNs_BLXaDEhsOwTzUV7rxFsA0',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'tls',
                'host' => 'localhost',
                'port' => '587',
                'username' => 'no-reply@virtualdars.uz',
                'password' => 'TIDDZM1qC1',
            ],
        ]
    ],
    'modules' => [
        'treemanager' => [
            'class' => '\kartik\tree\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
    ]

];
