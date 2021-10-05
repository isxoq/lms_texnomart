<?php


namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AdmintyAsset extends AssetBundle
{

//    public $sourcePath = '@frontend/web/template';

    public $basePath = '@webroot/template';
    public $baseUrl = '@homeUrl/template';

    public $css = [
        'assets/icon/feather/css/feather.css',
        'assets/css/style.css',
        'assets/css/jquery.mCustomScrollbar.css',
        'custom.css',
    ];

    public $js = [
        'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
        'bower_components/modernizr/modernizr.js',
        'assets/js/jquery.mCustomScrollbar.concat.min.js',
        'assets/js/SmoothScroll.js',
        'assets/js/pcoded.min.js',
        'assets/js/vartical-layout.min.js',
        'assets/js/script.min.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];

}
