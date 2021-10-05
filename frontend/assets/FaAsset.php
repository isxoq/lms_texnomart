<?php


namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class FaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@homeUrl';
    public $css = [
        'fa/css/font-awesome.min.css',
    ];

}