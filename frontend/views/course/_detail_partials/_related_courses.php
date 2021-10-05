<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 31.05.2021, 10:09
 */

/* @var $this \yii\web\View */
/* @var $relatedCourses mixed|null */


?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="r_course_title"><?= t('Related courses you may like') ?></h3>
    </div>
    <?php foreach ($relatedCourses as $course): ?>

        <div class="col-lg-6 col-xl-3">
            <?= $this->render('@frontend/views/course/_courses_partials/_course_card.php', [
                'model' => $course
            ]) ?>
        </div>

    <?php endforeach; ?>

</div>
