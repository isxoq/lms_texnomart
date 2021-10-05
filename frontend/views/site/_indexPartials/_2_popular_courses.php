<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */

use backend\modules\categorymanager\models\Category;
use frontend\models\Kurs;

$categories = Category::topCategories();
?>

    <!-- Top Courses -->
    <section id="top-courses" class="top_cours">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="main-title text-center">
                        <h3 class="mt0"><?= t('Popular courses') ?></h3>
                        <p><?= t('popular course description') ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="options" class="alpha-pag full">
                        <div class="option-isotop">
                            <ul id="filter" class="option-set" data-option-key="filter">
                                <li class="list-inline-item">
                                    <a class="selected"
                                       href="#category_all"
                                       data-option-value=".category_all">
                                        Barchasi
                                    </a>
                                </li>
                                <?php foreach ($categories as $key => $category): ?>
                                    <?php if (!empty(Kurs::topCourses($category->id))): ?>
                                        <li class="list-inline-item">
                                            <a href="#category_<?= $category->id ?>"
                                               data-option-value=".category_<?= $category->id ?>">
                                                <?= e($category->title) ?>
                                            </a>
                                        </li>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div><!-- FILTER BUTTONS -->
                    <div class="emply-text-sec">
                        <div class="row" id="masonry_abc">
                            <?php foreach (Kurs::topCourses() as $topCourse): ?>
                                <div class="col-md-6 col-lg-4 col-xl-3  category_all">
                                    <?= $this->render('@frontend/views/course/_courses_partials/_course_card', [
                                        'model' => $topCourse
                                    ]) ?>
                                </div>
                            <?php endforeach; ?>
                            <?php foreach ($categories as $key => $category): ?>
                                <?php foreach (Kurs::topCourses($category->id) as $topCourse): ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3  category_<?= $category->id ?>">
                                        <?= $this->render('@frontend/views/course/_courses_partials/_course_card', [
                                            'model' => $topCourse
                                        ]) ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="display: flex; justify-content: center">
                    <a href="<?= to(['course/all']) ?>" class="btn dbxshad btn-lg btn-thm circle white">
                        <?= t('All courses') ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php $js = <<<JS

    $('#masonry_abc').isotope({ filter: '.category_all' })

JS;
$this->registerJs($js);
?>