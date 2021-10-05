<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use common\components\virtualdars\VideojsWidget;

/* @var $this frontend\components\FrontendView */
/* @var $lesson frontend\modules\teacher\models\Lesson */

$this->title = $lesson->title;
$this->params['breadcrumbs'][] = ['label' => t('Courses'), 'url' => ['course/all']];
$this->params['breadcrumbs'][] = ['label' => $lesson->kurs->title, 'url' => ['course/detail', 'id' => $lesson->kurs->slug]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 15:45
 */

/* @var $this \frontend\components\FrontendView */
/* @var $model \frontend\models\Kurs */

$model = \frontend\models\Kurs::findOne($lesson->kurs->id);
$this->title = $lesson->title;

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
                            <?= VideojsWidget::widget([
                                'model' => $lesson,
                                'registerEvents' => false
                            ]);
                            ?>
                            <br>
                            <a href="<?= to(['course/detail', 'id' => $model->slug]) ?>" class="btn btn-primary">
                                <i class="flaticon-left-arrow"></i>
                                Kursga qaytish
                            </a>
                            <br>
                            <br>
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
