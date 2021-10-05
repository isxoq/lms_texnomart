<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 29.05.2021, 9:21
 */

use yii\helpers\HtmlPurifier;

/* @var $this \yii\web\View */
/* @var $model \backend\modules\kursmanager\models\KursComment|\frontend\models\Kurs */


?>

<div class="tab-pane fade show active" id="description" role="tabpanel"
     aria-labelledby="Overview-tab">
    <div class="cs_row_two csv2">
        <div class="cs_overview">
            <h4 class="title">
                <?= e($model->title) ?>
            </h4>

            <?= HtmlPurifier::process($model->description) ?>

            <?php if ($model->hasBenefits): ?>
                <hr>

                <h4><?= t('What will you learn in this course?') ?></h4>
                <ul class="cs_course_syslebus">
                    <?php foreach ($model->benefitsAsArray as $benefit): ?>
                        <li>
                            <i class="fa fa-check"></i>
                            <p> <?= e($benefit) ?></p>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>

            <?php if ($model->hasRequirements): ?>
                <hr>
                <h4><?= t('Requirements') ?></h4>
                <ul class="list_requiremetn">
                    <?php foreach ($model->requirementsAsArray as $requirement): ?>
                        <li>
                            <i class="fa fa-circle"></i>
                            <p><?= e($requirement) ?></p>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>

        </div>
    </div>
</div>
