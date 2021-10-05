<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use backend\modules\categorymanager\models\Category;

/* @var $this frontend\components\FrontendView */

$categories = Category::getCategoriesForIndexPage();
?>

<!-- School Category Courses -->
<section id="our-courses" class="our-courses bgc-f9">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0"><?= t('Categories') ?></h3>
                    <p><?= t('Categories courses text on index page') ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($categories as $category): ?>
                <div class="col-sm-6 col-lg-3">
                    <a href="<?= to(['course/all', 'category' => $category['slug']]) ?>">
                        <div class="img_hvr_box" style="background-image: url(<?= $category['image'] ?>);">
                            <div class="overlay">
                                <div class="details">
                                    <h5><?= $category['translation']['title'] ?></h5>
                                    <p><?= Category::getCoursesCount($category['id']) ?> <?= t('Courses') ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>