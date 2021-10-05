<?php

/* @var $this frontend\components\FrontendView */
/* @var $lesson backend\modules\kursmanager\models\Lesson */
/* @var $section backend\modules\kursmanager\models\Section */
/* @var $kurs backend\modules\kursmanager\models\Kurs */

$activeLesson = $this->params['_activeLesson'];

$this->title = $activeLesson->title;
$this->params['breadcrumbs'][] = $this->params['_activeKurs']['title'];
$this->params['breadcrumbs'][] = $this->params['_activeSectionTitle'];;
$this->params['breadcrumbs'][] = $activeLesson->title;


?>
<div class="card mb-1">
    <div class="card-body p-0 pl-3 pt-0">
        <?= \soft\adminty\Breadcrumbs::widget([
            'homeLink' => false,
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if ($activeLesson->isVideoLesson): ?>
            <?= $this->render('_mediaView', [
                'lesson' => $activeLesson,
            ]);
            ?>
        <?php endif ?>
        <br>
        <h4><?= $activeLesson->title ?></h4>
        <?php if ($activeLesson->description != null): ?>
            <p class=""><?= Yii::$app->formatter->asHtml($activeLesson->description) ?></p>
        <?php endif ?>
        <ul class="nav nav-tabs md-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="lesson-description-tab" data-toggle="tab" href="#lesson-description"
                   role="tab"
                   aria-controls="tab-v-1" aria-selected="false"> <i class="fa fa-info-circle"></i> Tavsif</a>
                <div class="slide"></div>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="lesson-files-tab" data-toggle="tab" href="#lesson-files" role="tab"
                   aria-controls="tab-v-2" aria-selected="false"> <i class="fa fa-download"></i> Yuklab olish uchun</a>
                <div class="slide"></div>
            </li>
        </ul>
        <div class="tab-content card-block">
            <div class="tab-pane fade active show" id="lesson-description" role="tabpanel"
                 aria-labelledby="lesson-description-tab">
                <?php if ($activeLesson->description != null): ?>
                    <p><?= Yii::$app->formatter->asHtml($activeLesson->description) ?></p>
                <?php else: ?>
                    <p class="text-primary">Ma'lumot topilmadi</p>
                <?php endif ?>
            </div>
            <div class="tab-pane fade" id="lesson-files" role="tabpanel" aria-labelledby="lesson-files-tab">
                <?php if (empty($files)): ?>
                    <p class="text-primary">Ma'lumot topilmadi</p>
                <?php else: ?>
                    <?php foreach ($files as $file): ?>
                        <?php /** @var frontend\modules\teacher\models\File $file */ ?>
                        <div class="row"style="margin-bottom: 5px">
                            <div class="col-md-10">
                                <b><?= e($file->title) ?></b>
                                <p> <?= Yii::$app->formatter->asHtml($file->description) ?></p>
                            </div>
                            <div class="col-md-2">
                                <b class="text-muted"> <?= Yii::$app->formatter->asFileSize($file->size) ?></b><br>
                                <?= a("Yuklab olish", ['download-file', 'id' => $file->id], ['class' => 'text-primary'], 'download') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div style="float: left">
            <?php if (isset($this->params['_prevLessonId'])): ?>
                <a href="<?= to(['/teacher/start/lesson', 'id' => $this->params['_prevLessonId']]) ?>"
                   class="text-primary">
                    <i class="fa fa-arrow-left"></i> <?= $this->params['_prevLessonTitle'] ?>
                </a>
            <?php endif ?>
        </div>
        <div style="float:right;">
            <?php if (isset($this->params['_nextLesson'])): ?>
                <?php
                    $nextLesson = $this->params['_nextLesson'];
                    $nextUrl = to(['/teacher/start/lesson', 'id' => $nextLesson->id]);
                ?>
                <a id="next-lesson-link" href="<?= $nextUrl ?>" class="text-primary">
                    <?= $nextLesson->title ?> <i class="fa fa-arrow-right"></i>
                </a>
            <?php endif ?>
        </div>
    </div>
</div>
