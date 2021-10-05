<?php

namespace common\components\virtualdars;

use frontend\assets\VideoJsAsset;
use Yii;
use backend\modules\kursmanager\models\Lesson;
use yii\helpers\Json;
use yii\web\JsExpression;

class VideojsWidget extends \soft\widget\VideojsWidget
{

    /**
     * @var Lesson
     */
    public $model;

    public $registerEvents = false;

    public function init()
    {
        $this->duration = intval($this->model->media_duration);
        $this->src = $this->model->media_stream_src;
        $this->poster =  $this->model->posterImage;
        $this->isYoutubeLink = $this->model->isYoutubeLink;
        parent::init();
    }

    public function registerAssets()
    {
        parent::registerAssets();
        if ($this->model->isYoutubeLink) {
            $this->view->registerJsFile('/videojs/js/youtube.min.js', [
                'depends' => VideoJsAsset::class,
            ]);
        }
        if ($this->registerEvents) {
            $this->initEvents();
        }
    }

    public function initEvents()
    {

        $url = to(['/profile/watch/save-watch', 'lesson_id' => $this->model->id]);
        $interval = Yii::$app->site->updateWatchInterval;

        $request = Yii::$app->request;
        $data = [
            $request->csrfParam => $request->csrfToken,
        ];

        $data = Json::encode($data);

        $playJs = new JsExpression("
            
            {$this->playerName}.on('playing', function(e){
                playVideo({$this->playerName} , '{$url}', {$interval}, {$data})
            })
             
             {$this->playerName}.on('pause', function(e){
                pauseVideo()
            })
        ");

        $this->view->registerJs($playJs);
    }

}