<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;

$referer = Yii::$app->request->referrer;

?>
<h4 class="">Xatolik yuz berdi!!!</h4>
<div class="alert alert-danger background-danger">
    <h4><?= Yii::$app->formatter->asHtml($message) ?></h4>
</div>
<p>
    <a href="<?= to('/teacher') ?>" class="btn btn-info" >  <i class="fa fa-home"></i> Bosh sahifa</a>
    <?php if ($referer): ?>
        <a href="<?= $referer ?>" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Ortga qaytish</a>
    <?php endif ?>
</p>

