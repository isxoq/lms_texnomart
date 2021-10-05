<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 29.05.2021, 9:17
 */

/* @var $this \yii\web\View */
/* @var $model \backend\modules\kursmanager\models\KursComment|\frontend\models\Kurs */
?>

<div class="cs_rwo_tabs csv2">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="Overview-tab" data-toggle="tab" href="#description"
               role="tab" aria-controls="Overview" aria-selected="true">
                <?= t('About course') ?>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="course-tab" data-toggle="tab" href="#lessons" role="tab"
               aria-controls="course" aria-selected="false">
                <?= t('Lessons') ?>
            </a>
        </li>

        <?php if (false): ?>
            <li class="nav-item">
                <a class="nav-link" id="course-tab" data-toggle="tab" href="#teacher" role="tab"
                   aria-controls="course" aria-selected="false">
                    <?= t('Teacher') ?>
                </a>
            </li>
        <?php endif ?>

        <li class="nav-item">
            <a class="nav-link" id="review-tab" data-toggle="tab" href="#reviews" role="tab"
               aria-controls="review" aria-selected="false">
                <?= t('Reviews') ?>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">



        <?= $this->render('__tab_description', ['model' => $model]) ?>
        <?= $this->render('__tab_lessons', ['model' => $model]) ?>

        <?//= $this->render('__tab_teacher', ['model' => $model]) // todo add teacher tab ?>

        <?= $this->render('__tab_reviews', ['model' => $model]) ?>


    </div>
</div>
