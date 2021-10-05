<?php

namespace frontend\assets\adminty;

class AdmintyChartBase extends \yii\web\AssetBundle
{

//    public $sourcePath = '@frontend/web/template';
    public $basePath = '@webroot/template';
    public $baseUrl = '@homeUrl/template';

    public $js = [
        'bower_components/chart.js/dist/Chart.js',
    ];

    public $depends = [
        'frontend\assets\AdmintyAsset',
    ];

}