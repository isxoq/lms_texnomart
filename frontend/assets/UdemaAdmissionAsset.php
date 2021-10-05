<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class UdemaAdmissionAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [

        //<!-- Main Stylesheet -->
        '/tempp/css/style.css',
        '/tempp/css/vendors.css',
        '/tempp/css/icon_fonts/css/all_icons.min.css',

        // <!-- SPECIFIC CSS -->
        "/tempp/css/skins/square/grey.css",
        "/tempp/css/wizard.css",

        '/tempp/css/custom.css',

    ];

    public $js = [

        // <!-- COMMON SCRIPTS -->
        '/tempp/js/common_scripts.js',
        '/tempp/js/main.js',
        '/tempp/assets/validate.js',

        // <!-- SPECIFIC SCRIPTS -->
        "/tempp/js/jquery-ui-1.8.22.min.js",
        "/tempp/js/jquery.wizard.js",
        "/tempp/js/jquery.validate.js",
        "/tempp/js/admission_func.js",
        '/tempp/js/custom.js',

    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];


}