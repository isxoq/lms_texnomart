<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class EdumyAsset extends AssetBundle
{

    public $baseUrl = '/edumy';

    public $css = [
//        'css/menu.css',
        'css/style.css',
        'css/responsive.css',
        "custom/custom.css",
    ];

    public $js = [


        ["js/jquery.mmenu.all.js", "type" => "text/javascript",],
        ["js/ace-responsive-menu.js", "type" => "text/javascript",],
        ["js/bootstrap-select.min.js", "type" => "text/javascript",],
        ["js/isotop.js", "type" => "text/javascript",],
        ["js/snackbar.min.js", "type" => "text/javascript",],
        ["js/simplebar.js", "type" => "text/javascript",],
        ["js/parallax.js", "type" => "text/javascript",],
        ["js/scrollto.js", "type" => "text/javascript",],
        ["js/jquery-scrolltofixed-min.js", "type" => "text/javascript",],
        ["js/jquery.counterup.js", "type" => "text/javascript",],
        ["js/wow.min.js", "type" => "text/javascript",],
        ["js/progressbar.js", "type" => "text/javascript",],
        ["js/slider.js", "type" => "text/javascript",],
        ["js/timepicker.js", "type" => "text/javascript",],
        ["js/script.js", "type" => "text/javascript",],
        ["custom/custom.js", "type" => "text/javascript",],

    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];


}