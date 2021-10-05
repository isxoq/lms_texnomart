<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>

<div class="site-error">

    <img src="" alt="">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-danger">
        <?= nl2br(Html::encode($message)) ?>
    </p>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

    <a class="btn btn-info" href="<?=\yii\helpers\Url::home()?>"><i class="fa fa-home"></i> <?=t('Back to home')?></a>

</div>

<style>
    .site-error{
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
</style>