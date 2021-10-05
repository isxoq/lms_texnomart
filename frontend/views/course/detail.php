<?php

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 15:45
 */

/* @var $this \frontend\components\FrontendView */
/* @var $model \frontend\models\Kurs */


$this->title = $model->title;

$this->metaTitle = $model->title;
$this->metaDescription = $model->meta_description == null ? $model->short_description : $model->meta_description;
$this->metaDescription = $model->meta_keywords;
$this->metaImage = $model->kursImage;

$this->params['breadcrumbs'][] = ['label' => t('Courses'), 'url' => ['course/all']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['renderBreadcrumb'] = false;

$relatedCourses = $model->relatedCourses(4);

?>
<?= $this->render('_detail_partials/_breadcrumb', [
    'model' => $model
]) ?>

<!-- Our Team Members -->
<section class="course-single2 pb40">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-9">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="courses_single_container">

                            <?php if ($model->preview_link): ?>
                                <div class="cs_row_one">
                                    <div class="cs_ins_container">
                                        <div class="courses_big_thumb">
                                            <div class="thumb">
                                                <iframe class="iframe_video"
                                                        src="https://www.youtube.com/embed/<?= Yii::$app->help->getVideoIdFromYoutubeUrl($model->preview_link) ?>?modestbranding=1&showinfo=0&fs=0&rel=0"
                                                        frameborder="0"
                                                        allowfullscreen
                                                ></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>

                            <?= $this->render('_detail_partials/_tabs', [
                                'model' => $model
                            ]) ?>


                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-xl-3">
                <?= $this->render('_detail_partials/_sidebar', ['model' => $model]) ?>
            </div>
        </div>
        <?php if (!empty($relatedCourses)): ?>
            <?= $this->render('_detail_partials/_related_courses', ['relatedCourses' => $relatedCourses]) ?>
        <?php endif ?>
    </div>
</section>