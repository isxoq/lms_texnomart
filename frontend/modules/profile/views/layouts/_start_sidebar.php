<?php

use backend\modules\kursmanager\models\Lesson;
use yii\helpers\ArrayHelper;

/** @var frontend\components\FrontendView $this */

$activeSectionId = $this->params['_activeSectionId'];
$activeLessonId = $_SESSION['_activeLessonData']['id'];
//$nextLessonId = $this->params['_nextLessonId'];
//$nextLessonTitle = $this->params['_nextLessonTitle'];
$activeSections = $this->params['_activeSections'];

$serialNumber = 1;

?>
<div class="card mb-1">
    <div class="card-body p-1">
        <div class="start-pills">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="<?= to(['/profile/default/my-courses']) ?>">
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
            $activeLessons = $section['activeLessons'];
            ?>
            <?php if (!empty($activeLessons)): ?>
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
                    } else if ($section['id'] == $activeSectionId) {
                        $class = 'show';
                    }

                    ?>

                    <div id="collapse<?= $sectionKey ?>" class="collapse <?= $class ?>"
                         aria-labelledby="heading<?= $sectionKey ?>" data-parent="#accordion">
                        <div class="card-body start-card-body">
                            <div class="list-group">
                                <?php foreach ($activeLessons as $lessonKey => $lesson): ?>
                                    <?php

                                    $url = to(['lesson', 'id' => $lesson['id']]);

                                    $duration = '';
                                    $watchedPercentText = '';
                                    if ($lesson['type'] != Lesson::TYPE_TASK) {

                                        $d = intval($lesson['media_duration']);
                                        if ($d > 0) {
                                            $duration = far('clock') . ' ' . Yii::$app->formatter->asGmtime($d);
                                        }

                                        if (isset($lesson['userLearnedLesson'])) {

                                            $watchedSeconds = intval(ArrayHelper::getValue($lesson, 'userLearnedLesson.watched_seconds', 0));
                                            if ($watchedSeconds > 0 && $lesson['media_duration'] > 0) {

                                                $percent = intval($watchedSeconds / $lesson['media_duration'] * 100);
                                                if ($percent > 100) {
                                                    $percent = 100;
                                                }

                                                $watchedPercentText = '<i class="far fa-eye"></i>' . $percent . '%';

                                            }
                                        }

                                    }

                                    $class = $activeLessonId == $lesson['id'] ? 'active' : '';
                                    $lessonTitle = $serialNumber . '. ' . trim($lesson['title']);

                                    $serialNumber++;
                                    $isCompleted = false;
                                    if (isset($lesson['userLearnedLesson']) && $lesson['userLearnedLesson']['is_completed']) {
                                        $isCompleted = true;
                                    }
                                    $checkIcon = $isCompleted ? '<i class="far fa-check-square"></i>' : '<i class="far fa-square"></i>';
                                    $lessonIcon = $lesson['type'] != Lesson::TYPE_TASK ? '<i class="far fa-play-circle"></i>' : '<i class="far fa-file-alt"></i>';


                                    ?>

                                    <a href="<?= $url ?>"
                                       class="list-group-item list-group-item-action <?= $class ?>"
                                       data-lesson-id="<?= $lesson['id'] ?>">
                                        <?= $checkIcon . ' ' . $lessonIcon . ' ' . e($lessonTitle) ?>
                                        <span class="right-text">
                                            <?= $watchedPercentText ?>
                                            <?= $duration ?>
                                        </span>

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
