<?php

use yii\helpers\Html;

/* @var $this frontend\components\FrontendView */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $allCount integer */

$this->title = "Mening kurslarim";
$this->params['breadcrumbs'][] = ['label' => "Profile", 'url' => '/profile'];
$this->params['breadcrumbs'][] = $this->title;
$models = $dataProvider->models;


?>

<?php if ($allCount > 3): ?>
    <div class="row">
        <div class="col-12 col-md-6">
            <?= Html::beginForm(['my-courses'], 'get') ?>
            <div class="input-group">
                <?= Html::textInput('title', $this->request->get('title'), [
                    'class' => 'form-control',
                    'placeholder' => "Kursni qidirish",
                ]) ?>
                <div class="input-group-prepend">
                    <button class="btn btn-info" type="submit" title="Qidirish"
                            style="padding-bottom: 5px; padding-top: 6px"><i
                                class="feather icon-search"></i></button>
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
<?php endif ?>

<?php if (!empty($models)): ?>

    <?php $this->registerAjaxCrudAssets(); ?>

    <div class="row simple-cards users-card">
        <?php foreach ($models as $model): ?>
            <?php
            /** @var \frontend\models\Kurs $model */
            $enroll = $model->userEnroll;

            $isExpired = $enroll->isExpired;
            $detailUrl = to(['/course/detail', 'id' => $model->slug, 'language' => 'uz']);

            $totalActiveLessons = $model->activeLessonsCount;
            $completedLessonsCount = $enroll->getCompletedLessonsCount();
            if ($completedLessonsCount > $totalActiveLessons){
                $completedLessonsCount = $totalActiveLessons;
            }
            if($totalActiveLessons <= 0){
                $percent = 0;
            }
            else{

                $percent = intval($completedLessonsCount / $totalActiveLessons * 100);
            }

            ?>
            <div class="col-md-4">
                <div class="card user-card">
                    <div class="card-header-img">
                        <img class="img-fluid img-radius" src="<?= $model->kursImage ?>" alt="card-img"
                             style="width: 90%">
                    </div>
                    <div style="width: 90%; margin-top: 10px">

                        <h5>
                            <?= Yii::$app->formatter->asHtml($model->title) ?>
                        </h5>
                        <p class="text-muted text-sm-center"><?= $model->subCategory->title ?></p>
                        <h6>
                            <span class="pcoded-micon"><i
                                        class="feather icon-user"></i></span>
                            <?= $model->user->fullname ?>
                        </h6>
                        <br>

                        <div class="progress" style="margin-left: 5%">
                            <div class="progress-bar progress-bar progress-bar-primary" role="progressbar"
                                 style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div style="text-align: right!important;">
                            <span class="text-muted">
                                <?= $completedLessonsCount ?>/<?= $totalActiveLessons ?> (<?= $percent ?>%)
                            </span>
                        </div>
                        <br>
                        <?php if ($isExpired): ?>
                            <p class="text-danger">A'zolik muddati tugagan</p>
                        <?php endif ?>

                        <a href="<?= to(['default/enrolling-info', 'id' => $model->id]) ?>" role="modal-remote"
                           class="btn btn-primary m-r-15 text-white enroll-info-button">Ma'lumotlar</a>

                        <?php if (!$isExpired): ?>
                            <a href="<?= to(['/profile/start', 'id' => $model->id]) ?>"
                               class="btn btn-success text-white">Boshlash</a>
                        <?php else: ?>

                            <a href="<?= to(['/course/enroll', 'id' => $model->slug]) ?>"
                               class="btn btn-success text-white">A'zo bo'lish</a>

                        <?php endif ?>

                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="row ">
        <div class="col-12">
            <?= \yii\bootstrap4\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </div>
    </div>
<?php else: ?>

    <h4 class="text-primary">
        Qidiruv natijalari bo'yicha ma'lumot topilmadi!
    </h4>

<?php endif ?>