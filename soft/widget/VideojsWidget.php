<?php

namespace soft\widget;

use yii\base\Widget;
use frontend\assets\VideoJsAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 *
 * @property string|mixed $playerName player name
 */
class VideojsWidget extends Widget
{

    /**
     * @var string Player name
     */
    private $_playerName;

    /**
     * @var string source url of video
     */
    public $src;

    /**
     * @var int|null the amount of seconds of video (optional)
     */
    public $duration;

    /**
     * @var string url to poster image
     */
    public $poster;

    /**
     * @var int Starter point of the video
     */
    public $currentTime = 0;

    /**
     * @var array Html options for video tag
     */
    public $options = [];

    /**
     * @var array videojs player 'src' options. This options will be rendered as javascript
     * @see https://docs.videojs.com/docs/api/player.html#Methodssrc
     */
    public $playerOptions = [];

    /**
     * @var bool
     */
    public $registerEvents = false;

    /**
     * @var bool
     */
    public $isYoutubeLink = false;

    /**
     * @return mixed
     */
    public function getPlayerName()
    {
        return $this->_playerName;
    }

    /**
     * @param mixed $playerName
     */
    public function setPlayerName($playerName)
    {
        $this->_playerName = $playerName;
    }

    public function run()
    {

        $this->options = ArrayHelper::merge($this->defaultOptions(), $this->options);
        Html::addCssClass($this->options, 'video-js vjs-theme-fantasy');

        $id = $this->options['id'];
        $this->playerName = 'player_' . $id;

        $this->playerOptions = ArrayHelper::merge($this->defaultPlayerOptions(), $this->playerOptions);
        $this->registerAssets();
        $vjsNoJs = '  <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>';
        echo Html::tag('video', $vjsNoJs, $this->options);

    }

    public function defaultOptions()
    {
        $options = [
            'id' => $this->getId(),
            'controls' => true,
            'preload' => 'auto',
            'height' => 'auto',

        ];

        if ($this->poster) {
            $options['poster'] = $this->poster;
        }
        return $options;
    }

    public function defaultPlayerOptions()
    {
        return [
            'src' => $this->src,
            'type' => $this->isYoutubeLink() ? 'video/youtube' : 'application/x-mpegURL',
            'withCredentials' => true,
        ];
    }

    public function registerAssets()
    {
        VideoJsAsset::register($this->view);
        $this->initPlayer();
        $this->setPlayerDuration();
        $this->setPlayerCurrentTime();

    }

    public function initPlayer()
    {

        $id = $this->options['id'];
        $playerOptions = Json::encode($this->playerOptions);
        $js = new JsExpression("
                var {$this->playerName} = videojs('{$id}',{
                     fluid: true
                });
                {$this->playerName}.src({$playerOptions});
                
                videojs('{$this->getId()}').ready(function() {
                  this.hotkeys({
                    volumeStep: 0.1,
                    seekStep: 5,
                    enableModifiersForNumbers: false
                  });
                });
                
            ");
        $this->view->registerJs($js);
    }

    public function setPlayerDuration()
    {
        $duration = intval($this->duration);
        if ($duration > 0) {
            $js = new JsExpression("
             {$this->playerName}.duration = function() {
                  return {$duration}; 
                }
            ");

            $this->view->registerJs($js);
        }
    }

    public function setPlayerCurrentTime()
    {
        $duration = intval($this->duration);
        $currentTime = intval($this->currentTime);
        if ($currentTime > 0) {
            if ($duration > 0) {
                if ($currentTime <= $duration) {
                    $js = new JsExpression("
                        {$this->playerName}.currentTime({$currentTime}) 
                    ");
                    $this->view->registerJs($js);
                }
            } else {
                $js = new JsExpression("
                        {$this->playerName}.currentTime({$currentTime}) 
                    ");
                $this->view->registerJs($js);
            }

        }
    }

    public function isYoutubeLink()
    {
        if ($this->isYoutubeLink) {
            return true;
        }

        return strpos($this->src, 'youtube') !== false;
    }

}