<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use yii\web\View;

/* @var $this frontend\components\FrontendView */

$sliders = \backend\modules\frontendmanager\models\CourseSlider::getDataForIndexPage();

?>

<section class="home-five bg-img5" style="background-image: url('<?= settings('site', 'index_banner_background') ?>')">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="home5_slider">
                    <div class="item">
                        <div class="home-text">
                            <h2>We Can T<span class="text-thm">each You!</span></h2>
                            <p>Technology is brining a massive wave of evolution on learning things on different ways.</p>
                            <a class="btn home_btn" href="#">Join In Free</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="home-text">
                            <h2>We Can T<span class="text-thm">each You!</span></h2>
                            <p>Technology is brining a massive wave of evolution on learning things on different ways.</p>
                            <a class="btn home_btn" href="#">Join In Free</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="home-text">
                            <h2>We Can T<span class="text-thm">each You!</span></h2>
                            <p>Technology is brining a massive wave of evolution on learning things on different ways.</p>
                            <a class="btn home_btn" href="#">Join In Free</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="home-text">
                            <h2>We Can T<span class="text-thm">each You!</span></h2>
                            <p>Technology is brining a massive wave of evolution on learning things on different ways.</p>
                            <a class="btn home_btn" href="#">Join In Free</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="home-text">
                            <h2>We Can T<span class="text-thm">each You!</span></h2>
                            <p>Technology is brining a massive wave of evolution on learning things on different ways.</p>
                            <a class="btn home_btn" href="#">Join In Free</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>