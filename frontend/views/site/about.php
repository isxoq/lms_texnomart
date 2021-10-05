<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this yii\web\View */

$this->title = t('About us');
$this->params['breadcrumbs'][] = $this->title;

$features = \backend\modules\frontendmanager\models\IndexInfo::getDataForAboutPage();
$teams = \backend\models\Team::getDataAsArray();
$settings = Yii::$app->settings;

?>

<div class="container margin_120_95">
    <div class="main_title_2">
        <span><em></em></span>
        <h2><?= t('Why choose us on about page') ?></h2>
        <p><?= t('Text for why choose us on about page') ?></p>
    </div>
    <div class="row">
        <?php foreach ($features as $feature): ?>

            <div class="col-lg-4 col-md-6">
                <a class="box_feat" href="#">
                    <?= $feature['icon'] ?>
                    <?php $tr = $feature['translations'][Yii::$app->language] ?>
                    <h3><?= $tr['title'] ?></h3>
                    <p><?= $tr['content'] ?></p>
                </a>
            </div>

        <?php endforeach ?>
    </div>
    <!--/row-->
</div>

<div class="bg_color_1">
    <div class="container margin_120_95">
        <div class="main_title_2">
            <span><em></em></span>
            <h2><?= t('Our origins and story title on about page') ?></h2>
            <p><?= t('Our origins and story text on about page') ?></p>
        </div>
        <div class="row justify-content-between">
            <div class="col-lg-6 wow" data-wow-offset="150">
                <figure class="block-reveal">
                    <div class="block-horizzontal"></div>
                    <img src="<?= $settings->get('site', 'our_story_image') ?>" class="img-fluid" alt="">
                </figure>
            </div>
            <div class="col-lg-5">
               <?= $settings->get('site', 'our_story_text') ?>
            </div>
        </div>
        <!--/row-->
    </div>
    <!--/container-->
</div>

<div class="container margin_120_95">
    <div class="main_title_2">
        <span><em></em></span>
        <h2><?= t('Our professional team') ?></h2>
        <p><?= t('Text for Our professional team') ?></p>
    </div>
    <div id="carousel" class="owl-carousel owl-theme">
        <?php foreach($teams as $team): ?>
        
        <div class="item">
            <a href="#">
                <div class="title">
                    <h4><?= e($team['fullname']) ?><em><?= $team['position'] ?></em></h4>
                </div>
                <img src="<?= $team['image'] ?>" alt="">
            </a>
        </div>
        
        <?php endforeach ?>
    </div>
    <!-- /carousel -->
</div>