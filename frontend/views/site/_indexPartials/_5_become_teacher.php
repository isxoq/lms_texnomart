<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */
$settings = Yii::$app->settings;
?>

<?php if ( is_guest() || user('isSimpleUser')): ?>
    <div class="call_section"
         style="background: url(<?= $settings->get('becomeTeacher', 'index_image') ?>) center center no-repeat fixed;">
        <div class="container clearfix">
            <div class="col-lg-5 col-md-6 float-right wow" data-wow-offset="250">
                <div class="block-reveal">
                    <div class="block-vertical"></div>
                    <div class="box_1">
                        <h3><?= e($settings->get('becomeTeacher', 'index_title')) ?></h3>
                        <p>
                            <?= Yii::$app->formatter->asHtml($settings->get('becomeTeacher', 'index_text')) ?>
                        </p>
                        <a href="<?= to(['site/become-teacher']) ?>" class="btn_1 rounded">
                            <?= t('Become Instructor') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
