<?php
return [
    'bundles' => [
        'yii\web\JqueryAsset' => [
            'sourcePath' => null,
            'baseUrl' => '/edumy',
            'js' => [
                [ 'js/jquery-3.3.1.js', 'type' => 'text/javascript'],
                ['js/jquery-migrate-3.0.0.min.js', 'type' => 'text/javascript'],
                ['js/popper.min.js', 'type' => 'text/javascript'],
            ]
        ],
        'yii\bootstrap\BootstrapAsset' => [
            'sourcePath' => null,
            'baseUrl' => '/edumy',
            'css' => [
                'css/bootstrap.min.css'
            ],
        ],

        'yii\bootstrap\BootstrapPluginAsset' => [
            'sourcePath' => null,
            'baseUrl' => '/edumy',
            'js' => [
                ['js/bootstrap.min.js', 'type' => 'text/javascript'],
            ],
        ],

        'yii\bootstrap4\BootstrapAsset' => [
            'sourcePath' => null,
            'baseUrl' => '/edumy',
            'css' => [
                'css/bootstrap.min.css'
            ],
        ],

        'yii\bootstrap4\BootstrapPluginAsset' => [
            'sourcePath' => null,
            'baseUrl' => '/edumy',
            'js' => [
                'js/popper.min.js',
                'js/bootstrap.min.js'
            ],
        ],

    ]
];