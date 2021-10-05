<?php

/* @var $this \yii\web\View */
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

$latestCourses = \frontend\models\Kurs::getLatestCoursesForPageSidebar();
$categories = \backend\modules\categorymanager\models\Category::find()->active()->forceLocalized()->asArray()->all();
?>

<div class="main_blog_post_widget_list">
    <div class="blog_search_widget">
        <form action="<?= to(['course/all']) ?>">

            <div class="input-group mb-3">
                <input type="text" class="form-control" name="title" placeholder="<?= t('Search courses') ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                        <span class="flaticon-magnifying-glass"></span>
                    </button>
                </div>
            </div>
        </form>

    </div>
    <div class="blog_category_widget">
        <ul class="list-group">
            <h4 class="title"><?= t('Categories') ?></h4>
            <?php foreach ($categories as $category): ?>

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="<?= to(['course/all', 'category' => $category['slug']]) ?>">
                        <i class="fa fa-angle-right"></i> <?= e($category['translation']['title']) ?>
                    </a>
                </li>

            <?php endforeach; ?>
        </ul>
    </div>
    <div class="blog_recent_post_widget media_widget">
        <h4 class="title"><?= t('New courses') ?></h4>
        <?php foreach ($latestCourses as $latestCourse): ?>
            <div class="media">
                <img class="align-self-start mr-3"
                     src="<?= $latestCourse->kursImage ?? settings('site', 'course_default_image') ?>" alt="image">
                <div class="media-body">
                    <a href="<?= $latestCourse->detailUrl ?>">

                        <h5 class="mt-0 post_title">
                            <?= e($latestCourse['title']) ?>
                        </h5>
                    </a>

                    <a href="#"><?= e($latestCourse->user->fullname ?? '') ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>