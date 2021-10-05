<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use yii\widgets\Pjax;

/* @var $this frontend\components\FrontendView */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = t('Our blog');
$this->params['breadcrumbs'][] = $this->title;

/** @var frontend\models\Post[] $models */
$models = $dataProvider->models;

$this->registerCssFile('@web/tempp/css/blog.css', ['depends' => 'frontend\assets\UdemaAsset']);

?>

    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-9">
                <?php foreach ($models as $model): ?>
                    <?php $detailUrl = $model->detailUrl; ?>
                    <article class="blog wow fadeIn">
                        <div class="row no-gutters">
                            <div class="col-lg-7">
                                <figure>
                                    <a href="<?= $detailUrl ?>"><img
                                                src="<?= $model->image ?>" alt="">
                                        <div class="preview"><span><?= t('Read more') ?></span></div>
                                    </a>
                                </figure>
                            </div>
                            <div class="col-lg-5">
                                <div class="post_info">
                                    <small></small>
                                    <h3><a href="<?= $detailUrl ?>"><?= e($model->title) ?></a></h3>
                                    <p>
                                        <?= $model->shortContent ?>
                                    </p>
                                    <ul>
                                        <li style="padding-left: 0px">
                                            <i class="icon-calendar"></i>
                                            <?= $model->formattedPublishedDate ?>
                                        </li>
                                        <li><i class="icon-eye"></i> <?= $model->view ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach ?>
                <div style="display: flex; justify-content: center">
                    <?= \yii\bootstrap4\LinkPager::widget([
                        'pagination' => $dataProvider->pagination
                    ]) ?>
                </div>
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
