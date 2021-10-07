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
        <img style="height: 400px; width: fit-content" src="/images/land.jpg" alt="">
    </div>

</div>