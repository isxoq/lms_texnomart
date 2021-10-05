<?php


namespace frontend\assets\adminty;


use yii\web\AssetBundle;

class AdmintyAmchartAsset extends AssetBundle
{

//    public $sourcePath = '@frontend/web/template';

    public $basePath = '@webroot/template';
    public $baseUrl = '@homeUrl/template';

    public $js = [
        'assets/pages/widget/amchart/amcharts.js',
        'assets/pages/widget/amchart/serial.js',
    ];

    public $depends = [
        'frontend\assets\adminty\AdmintyChartBase',
    ];

}