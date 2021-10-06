<?php

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 27.05.2021, 9:47
 */
/* @var $this \frontend\components\FrontendView */
$categories = \frontend\modules\mbapp\models\Category::find()->active()->asArray()->select('id,slug,status')->forceLocalized()->limit(6)->all();

?>

<!-- Our Footer -->
<section class="footer_one">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-3 col-lg-3">
                <div class="footer_contact_widget">
                    <h4><?= t('Contacts') ?></h4>
                    <p><span class="flaticon-placeholder-1"> </span><?= settings('site', 'company_address') ?></p>
                    <p><span class="flaticon-phone-call"> </span><?= settings('site', 'company_phone_number') ?></p>
                    <p><span class="flaticon-email"> </span><?= settings('site', 'company_email') ?></p>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-md-3 col-lg-3">
                <div class="footer_program_widget">
                    <h4><?= t('Courses') ?></h4>
                    <ul class="list-unstyled">
                        <?php foreach ($categories as $category): ?>
                            <li><a href="<?= to(['course/all', 'category' =>  $category['slug']]) ?>"><?= e($category['translation']['title']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-md-3 col-lg-3">
                <div class="footer_support_widget">
                    <h4>Qo'llab quvvatlash</h4>
                    <ul class="list-unstyled">

                        <li><a href="<?= to(['site/contact']) ?>"><?= t('Contacts') ?></a></li>
                        <li><a href="<?= to(['site/faq']) ?>">FAQ</a></li>
                        <?= $this->renderDynamic('return $this->render("@frontend/views/layouts/footer/__footer_user_menu");') ?>

                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
