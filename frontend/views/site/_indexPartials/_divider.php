<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 02.06.2021, 9:21
 */


/* @var $this \yii\web\View */
?>

<section class="divider_home1 parallax" data-stellar-background-ratio="0.3"
         style='background-image: url("<?= settings('becomeTeacher', 'index_image') ?>")'>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="divider-one">
                    <h1 class="color-white text-uppercase">  <?= Yii::$app->formatter->asHtml(settings('becomeTeacher', 'index_title')) ?></h1>
                    <p class="color-white"><?= e(settings('becomeTeacher', 'index_text')) ?></p>
                    <a class="btn btn-transparent divider-btn"
                       href="<?= to(['site/become-teacher']) ?>"> <?= t('Become Instructor') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

