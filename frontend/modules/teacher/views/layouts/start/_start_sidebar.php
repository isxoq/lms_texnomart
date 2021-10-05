<?php

use backend\modules\kursmanager\models\Lesson;

/** @var frontend\components\FrontendView $this */

$activeSectionId = $this->params['_activeSectionId'];
$activeLessonId = $this->params['_activeLesson']->id;
$activeSections = $this->params['_sections'];

$serialNumber = 1;

?>
<div class="card mb-1">
    <div class="card-body p-1">
        <div class="start-pills">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="<?= to(['/teacher/kurs/index']) ?>">
                        <span class="text-primary">
                        <i class="fas fa-arrow-left"></i>
                        Kurslarga qaytish
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php if (!empty($activeSections)): ?>
    <div id="accordion">

        <?php foreach ($activeSections as $sectionKey => $section): ?>

            <?php
            $lessons = $section['lessons'];
            ?>
            <?php if (!empty($lessons)): ?>
                <div class="card start-card">
                    <div class="card-header start-card-header" id="heading<?= $sectionKey ?>"
                         data-toggle="collapse" data-target="#collapse<?= $sectionKey ?>"
                         aria-expanded="true" aria-controls="collapse<?= $sectionKey ?>">
                        <b class="text-muted">
                            <?= e($section['title']) ?>

                        </b>
                    </div>

                    <?php

                    $class = '';
                    if ($activeSectionId == null && $sectionKey == 0) {
                        $class = 'show';
                    } elseif ($section['id'] == $activeSectionId) {
                        $class = 'show';
                    }

                    ?>

                    <div id="collapse<?= $sectionKey ?>" class="collapse <?= $class ?>"
                         aria-labelledby="heading<?= $sectionKey ?>" data-parent="#accordion">
                        <div class="card-body start-card-body">
                            <div class="list-group">
                                <?php foreach ($lessons as $lessonKey => $lesson): ?>
                                    <?php
                                    $url = to(['lesson', 'id' => $lesson['id']]);
                                    $class = $activeLessonId == $lesson['id'] ? 'active' : '';

                                    $lessonTitle = $serialNumber . '. ' . trim($lesson['title']);
                                    $serialNumber++;
                                    $lessonIcon = $lesson['type'] != Lesson::TYPE_TASK  ? '<i class="far fa-play-circle"></i>' : '<i class="far fa-file-alt"></i>';

                                    ?>

                                    <a href="<?= $url ?>" class="list-group-item list-group-item-action <?= $class ?>"
                                       data-lesson-id="<?= $lesson['id'] ?>">
                                        <?= $lessonIcon . ' ' . e($lessonTitle)  ?>
                                        <?php if ($lesson['type'] != Lesson::TYPE_TASK ): ?>
                                        <?php $duration = $lesson['media_duration']; ?>
                                        <span class="right-text">
                                            <?= far('clock') . ' ' . Yii::$app->formatter->asGmtime($duration) ?>
                                        </span>
                                        <?php endif ?>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>

        <?php endforeach ?>

    </div>
<?php endif ?>
