<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use yii\web\View;

/* @var $this frontend\components\FrontendView */

$sliders = \backend\modules\frontendmanager\models\CourseSlider::getDataForIndexPage();

?>


<!-- 2nd Home Slider -->
<div class="home1-mainslider">
    <div class="container-fluid p0">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-banner-wrapper" style="height: 450px">
                    <div class="banner-style-one owl-theme owl-carousel">
                        <?php foreach ($sliders as $slider): ?>

                            <div class="slide slide-one"
                                 style="background-image: url(<?= $slider['image'] ?>); height: 400px; padding-top: 100px">
                                <div class="container">
                                    <div class="row home-content" style="padding-top: 0">
                                        <div class="col-lg-12 text-center p0">
                                            <h4 class="banner-title"
                                                style="padding: 0 10%; ">  <?= e($slider['translation']['title']) ?></h4>
                                            <p> <?= e($slider['translation']['text']) ?></p>
                                            <div class="btn-block">
                                                <a href="<?= to(['course/detail', 'id' => $slider['course']['slug']]) ?>" class="banner-btn">
                                                    <?= t('Read more') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-btn-block banner-carousel-btn">
                        <span class="carousel-btn left-btn" >
                            <i class="flaticon-left-arrow left" style="font-size: 30px"></i>
                        </span>
                        <span class="carousel-btn right-btn" >
                            <i class="flaticon-right-arrow-1 right" style="font-size: 30px"></i></span>
                    </div><!-- /.carousel-btn-block banner-carousel-btn -->
                </div><!-- /.main-banner-wrapper -->
            </div>
        </div>
    </div>

</div>