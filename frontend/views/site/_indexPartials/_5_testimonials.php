<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 27.05.2021, 10:00
 */

use backend\modules\kursmanager\models\KursComment;

/* @var $this \yii\web\View */

$testimonials = KursComment::find()
    ->active()
    ->andWhere(['show_on_slider' => true])
    ->latest()
    ->with(['kurs', 'user'])
    ->all();

?>
<section id="our-testimonials" class="our-testimonials">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0"><?= t('What people say') ?></h3>
                    <p><?= t('What people say text') ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="testimonialsec">
                    <ul class="tes-nav">
                        <?php foreach ($testimonials as $testimonial): ?>
                        <li>
                            <img class="img-fluid" src="<?= $testimonial->user->image ?>" alt="user image"/>
                        </li>
                        <?php endforeach;  ?>

                    </ul>
                    <ul class="tes-for">
                        <?php foreach ($testimonials as $testimonial): ?>
                        <li>
                            <div class="testimonial_item">
                                <div class="details">
                                    <h5><?= e($testimonial->user->fullname) ?></h5>
                                    <span class="small text-thm"><?= e($testimonial->kurs->title) ?></span>
                                    <p>    <?= Yii::$app->formatter->asHtml($testimonial->text) ?></p>
                                </div>
                            </div>
                        </li>
                        <?php endforeach;  ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

