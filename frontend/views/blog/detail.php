<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */
/* @var $model backend\modules\postmanager\models\Post */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => t('Our blog'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/tempp/css/blog.css', ['depends' => 'frontend\assets\UdemaAsset']);

$this->metaTitle = $model->metaTitle;
$this->metaDescription = $model->metaDescription;
$this->metaImage = $model->image;
$this->metaKeywords = $model->meta_keywords;
?>


    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-9">
                <div class="bloglist singlepost">
                    <h1><?= e($model->title) ?></h1>
                    <div class="postmeta">
                        <ul>
                            <li><a href="<?= to(['blog/index', 'category' => $model->category->slug]) ?>"><i class="icon_folder-alt"></i> <?= $model->category->title ?></a></li>
                            <li><a href="#"><i class="icon_clock_alt"></i> <?= $model->formattedPublishedDate ?> </a></li>
                            <li><a href="#"><i class="icon-eye"></i> <?= $model->view ?> </a></li>
                        </ul>
                    </div>
                    <!-- /post meta -->
                    <div class="post-content">
                        <div class="dropcaps">
                            <?= Yii::$app->formatter->asHtml($model->content) ?>
                        </div>

                    </div>
                    <!-- /post -->
                </div>
                <!-- /single-post -->


                <hr>

            </div>
            <!-- /col -->

            <aside class="col-lg-3">
                <?= $this->render('_blogSidebar') ?>
            </aside>
            <!-- /aside -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->

