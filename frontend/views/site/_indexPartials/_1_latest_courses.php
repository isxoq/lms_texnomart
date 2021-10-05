<?php

/* @var $this \soft\web\SView */
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 16.07.2021, 11:16
 */

$latestCourses = \frontend\models\Kurs::latestCourses();

?>

<!-- Our Popular Courses -->
<section class="popular-courses">
    <div class="container-fluid style2">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0">Yangi kurslar</h3>
                    <p class="">Eng yangi qo'shilgan video kurslar</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="popular_course_slider" style="height: 400px">
                    <?php foreach ($latestCourses as $latestCourse): ?>
                        <div class="item">
                            <?= $this->render('@frontend/views/course/_courses_partials/_course_card', [
                                'model' => $latestCourse
                            ]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
