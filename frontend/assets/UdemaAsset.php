<?php


namespace frontend\assets;

use yii\web\AssetBundle;

class UdemaAsset extends AssetBundle
{

    public $sourcePath = '@frontend/web/tempp';

//    public $basePath = '@webroot/tempp';
//    public $baseUrl = '/tempp';

    public $css = [

        //<!--Iconfont Css -->
        'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800',

        //<!-- Main Stylesheet -->
        'css/style.css',
        'css/vendors.css',
        'css/icon_fonts/css/all_icons.min.css',
        'css/custom.css',
    ];

    public $js = [
        'js/common_scripts.js',
        'js/main.js',
        'assets/validate.js',
        'js/custom.js',
        'js/custom.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];


}