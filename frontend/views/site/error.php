<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;


?>
<div id="error_page" style="padding: 100px 0">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-xl-7 col-lg-9">
                <h2 style="font-size: 60px"><?= $exception->statusCode ?> <i class="icon_error-triangle_alt"></i></h2>
                <p style="font-size: 30px"><?= nl2br(Html::encode($message)) ?></p>
                <form action="<?= to(['course/all']) ?>" class="">
                    <div class="form-group">
                        <input type="text" required class="form-control" name="title"
                               placeholder="<?= t('What are you looking for?') ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-success">
                            <i class='flaticon-magnifying-glass'></i>
                            <?= t('Search') ?>
                        </button>
                    </div>
                </form>

                <?php if (!empty(Yii::$app->request->referrer)): ?>
                    <a href="<?= Yii::$app->request->referrer ?>" class="btn btn-lg btn-primary">
                        <i class="fa fa-arrow-left"></i> <?= t('Return back') ?> </a>
                <?php endif ?>

                <a href="<?= to(['site/index']) ?>" class="btn btn-lg btn-info">
                    <i class="fa fa-home"></i> <?= t('Home') ?>
                </a>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>


