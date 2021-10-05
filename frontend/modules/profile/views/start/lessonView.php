<?php

use soft\adminty\Breadcrumbs;

/* @var $this frontend\components\FrontendView */
/* @var $lesson backend\modules\kursmanager\models\Lesson */
/* @var $section backend\modules\kursmanager\models\Section */
/* @var $kurs backend\modules\kursmanager\models\Kurs */

/** @var frontend\modules\teacher\models\Lesson $activeLesson */
$activeLesson = $this->params['_activeLesson'];

$this->params['breadcrumbs'][] = $this->params['_activeKurs']['title'];
$this->params['breadcrumbs'][] = $this->params['_activeSectionTitle'];
$this->params['breadcrumbs'][] = $activeLesson->title;

$this->title = $activeLesson->title;

/** @var frontend\modules\teacher\models\File[] $files */
$files = $activeLesson->getFiles()->active()->all();

$description = $activeLesson->description;

$hasDescription = !empty($description);
$hasFiles = !empty($files);

?>
<div class="card mb-1">
    <div class="card-body p-0 pl-3 pt-0">
        <?= Breadcrumbs::widget([
            'homeLink' => false,
            'links' => $this->params['breadcrumbs'] ?? [],
        ]) ?>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <?php if ($activeLesson->isVideoLesson && $activeLesson->hasStreamedVideo): ?>
            <?= $this->render('_mediaView', [
                'lesson' => $activeLesson,
            ]);
            ?>
        <?php endif ?>
        <br>
        <h3><?= $activeLesson->title ?></h3>

        <?php if ($hasDescription || $hasFiles): ?>
            <ul class="nav nav-tabs md-tabs" role="tablist">

                <?php if ($hasDescription): ?>
                    <li class="nav-item ">
                        <a class="nav-link active" id="lesson-description-tab" data-toggle="tab"
                           href="#lesson-description"
                           role="tab"
                           aria-controls="tab-v-1" aria-selected="false"> <i class="fa fa-info-circle"></i> Tavsif</a>
                        <div class="slide"></div>
                    </li>
                <?php endif ?>

                <?php if ($hasFiles): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?= !$hasDescription ? 'active' : '' ?>" id="lesson-files-tab"
                           data-toggle="tab" href="#lesson-files" role="tab"
                           aria-controls="tab-v-2" aria-selected="false"> <i class="fa fa-download"></i>
                            Yuklab olish uchun
                            <label class="badge badge-primary"><?= count($files) ?></label>
                        </a>
                        <div class="slide"></div>
                    </li>
                <?php endif ?>

            </ul>
            <div class="tab-content card-block">

                <?php if ($hasDescription): ?>
                    <div class="tab-pane fade active show" id="lesson-description" role="tabpanel"
                         aria-labelledby="lesson-description-tab">
                        <p><?= Yii::$app->formatter->asHtml($description) ?></p>
                    </div>
                <?php endif ?>

                <?php if ($hasFiles): ?>
                    <div class="tab-pane fade <?= !$hasDescription ? 'active show' : '' ?>" id="lesson-files"
                         role="tabpanel" aria-labelledby="lesson-files-tab">

                        <?php foreach ($files as $file): ?>
                            <?php /** @var frontend\modules\teacher\models\File $file */ ?>
                            <div class="row" style="margin-bottom: 5px">
                                <div class="col-md-8">
                                    <b><?= e($file->title) ?></b>
                                    <p>
                                        <?php if (!empty($file->description)): ?>
                                            <?= Yii::$app->formatter->asHtml($file->description) ?>
                                            <br>
                                        <?php endif ?>
                                        <b class="text-muted"> <?= Yii::$app->formatter->asFileSize($file->size) ?></b>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <?= a('Yuklab olish', ['download-file', 'id' => $file->id], ['class' => 'btn btn-primary'], 'download') ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>

            </div>
        <?php endif ?>

    </div>
</div>

<div class="card">
    <div class="card-body">
        <div style="float: left">
            <?php if (isset($this->params['_prevLessonId'])): ?>
                <a href="<?= to(['/profile/start/lesson', 'id' => $this->params['_prevLessonId']]) ?>"
                   class="text-primary">
                    <i class="fa fa-arrow-left"></i> <?= $this->params['_prevLessonTitle'] ?>
                </a>
            <?php endif ?>
        </div>
        <div style="float:right;">
            <?php if (isset($this->params['_nextLessonId'])): ?>
                <a href="<?= to(['/profile/start/lesson', 'id' => $this->params['_nextLessonId']]) ?>"
                   class="text-primary">
                    <?= $this->params['_nextLessonTitle'] ?> <i class="fa fa-arrow-right"></i>
                </a>
            <?php endif ?>
        </div>
    </div>
</div>
