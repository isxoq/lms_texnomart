<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 29.05.2021, 9:22
 */

/* @var $this \yii\web\View */
/* @var $model \backend\modules\kursmanager\models\KursComment|\frontend\models\Kurs */

$sections = $model->activeSectionsForDetailPage;

?>

<div class="tab-pane fade" id="lessons" role="tabpanel" aria-labelledby="review-tab">
    <div class="cs_row_three csv2">
        <div class="course_content">
            <div class="cc_headers">
                <h4 class="title"><?= t('Lessons') ?></h4>
                <ul class="course_schdule float-right">
                    <li class="list-inline-item">
                        <a href="#">
                            <?= t("Lessons count") . ": <b>" . $model->activeLessonsCount ?>  ta</b>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <?= t("Duration") . ": <b>" . $model->formattedActiveLessonsDuration ?></b>
                        </a>
                    </li>
                </ul>
            </div>
            <br>
            <?php foreach ($sections as $key => $section): ?>

                <?php
                $isFirst = $key == 0;
                $section_id = 'section-' . $key;
                ?>
                <div class="details">
                    <div id="accordion" class="panel-group cc_tab">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#<?= $section_id ?>"
                                       class="accordion-toggle link"
                                       data-toggle="collapse" data-parent="#accordion">
                                        <?= $key + 1 . '. ' . e($section['title']) ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="<?= $section_id ?>"
                                 class="panel-collapse collapse <?= $isFirst ? 'show' : '' ?>">
                                <div class="panel-body">
                                    <ul class="cs_list mb0">
                                        <?php foreach ($section->activeLessonsAsArray as $lesson): ?>
                                            <li>
                                                <span class="flaticon-play-button-1 icon"></span>

                                                <span class="lesson-title"> <?= e($lesson['title']) ?></span>

                                                <?php if (intval($lesson['media_duration']) > 0): ?>
                                                    <span class="cs_time" style="float: right">
                                                            <span class="flaticon-clock icon"></span>
                                                            <?= Yii::$app->formatter->asGmtime($lesson['media_duration']) ?>
                                                        </span>
                                                <?php endif ?>

                                                <?php if ($lesson['is_open']): ?>
                                                    <span class="cs_preiew" style="float:right; margin-right: 30px">
                                                             <a href="<?= to(['/course/preview', 'id' => $lesson['id']]) ?>"
                                                                class="text-info" style="font-size: 15px">
                                                             <?= t('Oldindan korish') ?>
                                                             </a>
                                                        </span>
                                                <?php endif ?>

                                            </li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>