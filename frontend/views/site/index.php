<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */

$this->title =  settings('site', 'site_title');
$this->metaTitle = settings('meta', 'meta_title');
$this->params['renderBreadcrumb'] = false;
?>


<?= $this->render('_indexPartials/_1_slider') ?>
<?= $this->render('_indexPartials/_1_latest_courses') ?>
<?= $this->render('_indexPartials/_2_popular_courses') ?>
<?//= $this->render('_indexPartials/_divider') ?>
<?//= $this->render('_indexPartials/_3_about') ?>
<?= $this->render('_indexPartials/_3_categories') ?>
<?//= $this->render('_indexPartials/_5_testimonials') ?>
<?//= $this->render('_indexPartials/_6_divider') ?>







