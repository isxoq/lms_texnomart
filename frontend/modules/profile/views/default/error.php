<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<!-- Start of .about -->
<section class="contact-page">
    <div class="container">
        <div class="row">
            <div class="col-12 contact-page__first-title">
                <h1 class="title-2"><?= e($this->title) ?></h1>
            </div>
            <div class="col-12 alert alert-danger background-danger">
                <span class="f-20"> <?= nl2br(Html::encode($message)) ?></span>
            </div>
        </div>
    </div>
</section>
<!-- End of .about -->

