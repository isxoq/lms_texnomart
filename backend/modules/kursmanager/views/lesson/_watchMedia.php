<?php
/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */
?>

<link rel="stylesheet" href="http://videojs.github.io/video.js/video-js/skins/vim.css">


<?= \common\components\virtualdars\VideojsWidget::widget([
    'model' => $model,
    'options' => [
        'class' => 'video-js vim-css'
    ],
    'registerEvents' => false
]) ?>
<br>
<p>
    <a href="<?= to(['upload', 'id' => $model->id]) ?>" class="btn btn-info">
        <i class="fa fa-upload"></i> Boshqa video yuklash
    </a>
    <a href="<?= to(['delete-media', 'id' => $model->id]) ?>" class="btn btn-danger"
       data-confirm="Siz rostdan ham ushbu videoni o`chirmoqchimisiz?" data-method="post">
        <i class="fa fa-trash-alt"></i> Videoni o'chirish
    </a>


</p>