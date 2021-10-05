<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use yii\widgets\Pjax;

/* @var $this frontend\components\FrontendView */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = t("Courses");
$this->params['breadcrumbs'][] = $this->title;

/** @var frontend\models\Kurs[] $models */
$models = $dataProvider->models;

$this->registerJsFile('/edumy/custom/course.sort.js', [
    'depends' => \yii\widgets\PjaxAsset::class,
]);

?>

<section class="our-team pb40">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-9">
                <?= $this->render('_courses_partials/_top_search') ?>
                <div class="row" id="courses-list-container">
                    <?= $this->render('_courses_partials/_courses_grid_view', ['dataProvider' => $dataProvider]) ?>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <?= $this->render('_courses_partials/_sidebar') ?>
            </div>
        </div>
    </div>
</section>

<input type="hidden" id="course-all-base-url" value="<?= to(['course/all']) ?>">