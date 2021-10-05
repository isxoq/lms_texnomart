<?php

/** @var frontend\components\FrontendView $this */

$settings = Yii::$app->settings;

$renderBreadcrumb = \yii\helpers\ArrayHelper::getValue($this->params, 'renderBreadcrumb', true);

?>

<?php if ($this->beginCache("_header_1_menu_" . Yii::$app->language, [
    'duration' => Yii::$app->params['pageCacheDuration'],
    'dependency' => [
        'class' => 'yii\caching\TagDependency',
        'tags' => ['menu']
    ],
])): ?>

    <?= $this->render('header/_header_1_menu'); ?>

    <?php $this->endCache(); ?>
<?php endif ?>


<?//= $this->render('header/_header_1_menu') ?>
<?= $this->render('header/_header_2_signup_modal') ?>
<?= $this->render('header/_header_3_search') ?>


<?php if ($this->beginCache("_header_4_mobile_menu_" . Yii::$app->language, [
    'duration' => Yii::$app->params['pageCacheDuration'],
    'dependency' => [
        'class' => 'yii\caching\TagDependency',
        'tags' => ['menu']
    ],
])): ?>

    <?= $this->render('header/_header_4_mobile_menu'); ?>

    <?php $this->endCache(); ?>
<?php endif ?>

<?//= $this->render('header/_header_4_mobile_menu') ?>

<?php if ($renderBreadcrumb): ?>
    <?= $this->render('header/_header_5_breadcrumb') ?>
<?php endif ?>

