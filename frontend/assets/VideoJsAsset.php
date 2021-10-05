<?php


namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class VideoJsAsset  extends AssetBundle
{

    public $basePath = '@webroot/';
    public $baseUrl = '@homeUrl/';

    public $css = [
        '/videojs/css/video-js.css',
        '/videojs/css/videojs-fantasy-theme.css',
    ];

    public $js = [
      'videojs/js/video.js',
      'videojs/js/videojs-http-streaming.js',
      'videojs/js/videojs.events.js',
      'videojs/js/videojs.hotkeys.min.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];

}