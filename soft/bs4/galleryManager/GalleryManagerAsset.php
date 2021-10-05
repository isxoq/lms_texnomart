<?php


namespace soft\bs4\galleryManager;


class GalleryManagerAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@zxbodya/yii2/galleryManager/assets';
    public $js = [
//        'jquery.iframe-transport.js',
//        'jquery.galleryManager.js',
         'jquery.iframe-transport.min.js',
        // 'jquery.galleryManager.min.js',
    ];
    public $css = [
        'galleryManager.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset'
    ];
}