<?php

namespace frontend\assets;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class ToastrMinAsset extends AssetBundle
{
    public $basePath = '@homeUrl';
    public $baseUrl = '@homeUrl';

    public $css = [
        'min/toastr/toastr.min.css'
    ];
    public $js = [
        'min/toastr/toastr.min.js'
    ];

    public $depends = [
      JqueryAsset::class,
    ];

}