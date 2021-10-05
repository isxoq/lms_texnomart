<?php

namespace soft\widget\ajaxcrud;

class CrudAsset extends \yii\web\AssetBundle
{

//    public $publishOptions = [
//        'forceCopy' => true,
//    ];

    public $sourcePath = '@frontend/web/plugin_assets/ajaxcrud';

    public $css = [
        'ajaxcrud.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kartik\grid\GridViewAsset',
    ];

    public $js = [
        'ModalRemote.js',
        'ajaxcrud.js',
    ];

}