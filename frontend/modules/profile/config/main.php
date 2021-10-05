<?php
return [
    'components' => [

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => "/",
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                '<language:\w+>/course/detail/<id>' => 'course/detail',
//                'profile/start/<id>' => 'profile/start',
//                'profile/start/index<id>' => 'profile/start/index',
                'profile/cabinet' => 'profile/cabinet/index',
                'profile/cabinet/index<id>' => 'profile/cabinet/index',
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
        'errorHandler' => [
            'class' => "yii\web\ErrorHandler",
            'errorAction' => '/profile/default/error',
        ],
    ],
    'params' => [
       'bsVersion' => '4',
    ],
];