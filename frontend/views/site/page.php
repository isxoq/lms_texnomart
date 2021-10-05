<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/** @var backend\modules\pagemanager\models\Page $model */
/* @var $this \yii\web\View */

$this->title = $model->title;


?>

<section class="blog_post_container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="main_blog_post_content">
                    <div class="mbp_thumb_post">
                        <div class="details">
                            <h2 align="center"><?= e($model->title) ?></h2>
                            <p>  <?= Yii::$app->formatter->asHtml($model->description) ?></p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-xl-3 pl10 pr10">
                <?= $this->render('_pageSidebarPanel') ?>
            </div>
        </div>
    </div>
</section>