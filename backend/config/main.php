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
    'language' => "uz",
    'bootstrap' => ['log'],
    'homeUrl' => '/admin',
    'modules' => [
        'acf' => [
            'class' => 'backend\modules\acf\Module',
            'languages' => function () {
                return Yii::$app->site->languages();
            }
        ],

        'botmanager' => [
            'class' => 'backend\modules\botmanager\Module',
        ],
        'faqmanager' => [
            'class' => 'backend\modules\faqmanager\Module',
        ],

        'billing' => [
            'class' => 'backend\modules\billing\Billing',
        ],
        'testcrud' => [
            'class' => 'backend\modules\testcrud\Modul',
        ],

        'octouz' => [
            'class' => 'backend\modules\octouz\OctoUz',
        ],

        'frontendmanager' => [
            'class' => 'backend\modules\frontendmanager\Frontendmanager',
        ],

        'menumanager' => [
            'class' => 'backend\modules\menumanager\Module',
        ],

        'click' => [
            'class' => '\backend\modules\click\Click',
        ],

        'settings' => [
            'class' => 'backend\modules\settings\Module',
        ],

        'postmanager' => [
            'class' => '\backend\modules\postmanager\Module',
        ],

        'profilemanager' => [
            'class' => '\backend\modules\profilemanager\Module',
        ],

        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'translate-manager' => [
            'class' => '\backend\modules\translationmanager\TranslationManager',
        ],
        'pagemanager' => [
            'class' => 'backend\modules\pagemanager\Module',
        ],
        'contactmanager' => [
            'class' => 'backend\modules\contactmanager\Module',
        ],
        'socialmanager' => [
            'class' => 'backend\modules\socialmanager\Module',
        ],
        'categorymanager' => [
            'class' => 'backend\modules\categorymanager\Module',
        ],
        'usermanager' => [
            'class' => 'backend\modules\usermanager\Module',
        ],
        'kursmanager' => [
            'class' => 'backend\modules\kursmanager\Modul',
        ],
        'import' => [
            'class' => 'backend\modules\import\Module',
        ],
        'ordermanager' => [
            'class' => 'backend\modules\ordermanager\Module',
        ],
        'smsmanager' => [
            'class' => 'backend\modules\smsmanager\Module',
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl' => '/uploads/files',
                    'basePath' => '@frontend/web/uploads/files',
                    'name' => 'Uploads'
                ],

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
    'components' => [
        'billing' => [
            'class' => 'backend\modules\billing\components\Billing'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],

        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@frontend/web',
                    'baseUrl' => '@homeUrl/',
                    'js' => [
                        '/template/bower_components/jquery/dist/jquery.min.js',
                    ]
                ],

                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@frontend/web',
                    'baseUrl' => '@homeUrl/',
                    'css' => [
                        '/template/bower_components/bootstrap/dist/css/bootstrap.min.css',
                    ]
                ],

                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@frontend/web',
                    'baseUrl' => '@homeUrl/',
                    'js' => [
                        '/template/bower_components/jquery-ui/jquery-ui.min.js',
                        '/template/bower_components/popper.js/dist/umd/popper.min.js',
                        '/template/bower_components/bootstrap/dist/js/bootstrap.min.js',
                    ]
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'js' => [],
                    'depends' => [
                        'yii\bootstrap\BootstrapPluginAsset'
                    ],
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'css' => [],
                    'depends' => ['yii\bootstrap\BootstrapAsset'],
                ],
            ]
        ],

        'view' => [
            'class' => '\backend\components\BackendView',
        ],
        'request' => [
            'baseUrl' => "/admin",
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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

        'urlManager' => [
            'baseUrl' => "/admin",
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],

    'params' => $params,
];