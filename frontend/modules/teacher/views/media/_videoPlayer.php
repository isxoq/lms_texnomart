<?php
/* @var $this \yii\web\View */
/* @var $model frontend\modules\teacher\models\Media */
?>
<<<<<<< HEAD
<video
    id="my-video"
    class="video-js"
    controls
    preload="auto"
    width="720"
    height="405"
    poster="<?= $model->poster ?>"
    data-setup="{}"
>
    <p class="vjs-no-js">
        To view this video please enable JavaScript, and consider upgrading to a web browser that
        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
</video>
=======

<?= \common\components\virtualdars\VideojsWidget::widget([
    'model' => $model,
]) ?>
>>>>>>> c69cbafa39212798b910cb1f615b88abc7d779fe
<br>
<p>
    <?= a("Videoni o'chirish", ['delete-video', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Siz rostdanham ushbu videoni o`chirmoqchimisiz?',
            'method' => 'post',
        ]
    ], 'trash-alt') ?>
</p>

<<<<<<< HEAD
      var player = videojs('my-video');
      
      player.duration = function() {
  return {$model->duration}; // the amount of seconds of video
};
      
        player.src({
            src: '{$model->stream_src}',
            type: 'application/x-mpegURL',
            withCredentials: true
        });
";

$this->registerJs($js, \yii\web\View::POS_READY);
?>
=======
>>>>>>> c69cbafa39212798b910cb1f615b88abc7d779fe

