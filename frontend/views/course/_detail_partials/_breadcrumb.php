<?php

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 15:50
 */

/* @var $this \yii\web\View */
/* @var $model \backend\modules\kursmanager\models\KursComment|\frontend\models\Kurs */

/** @var \common\models\User $user Author of the course */
$user = $model->user;

$activeCommentsCount = $model->activeCommentsCount;
?>
<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb csv2" style="background: url('<?= settings('site', 'pages_banner') ?>')">
    <div class="container">
        <div class="row">
            <div class="col-xl-9">
                <div class="breadcrumb_content">
                    <div class="cs_row_one csv2">
                        <div class="cs_ins_container">
                            <div class="cs_instructor">
                                <ul class="cs_instrct_list float-left mb0">
                                    <li class="list-inline-item"><img class="thumb" src="<?= $user->image ?>" alt="" style="border-radius: 100%">
                                    </li>
                                    <li class="list-inline-item"><a class="color-white" href="#">
                                            <?= e($user->fullname) ?>
                                        </a></li>

                                </ul>

                                <?php if (false): //todo add to wishlist  ?>
                                    <ul class="cs_watch_list float-right mb0">
                                        <li class="list-inline-item"><a class="color-white" href="#"><span
                                                        class="flaticon-like"></span></a></li>
                                        <li class="list-inline-item"><a class="color-white" href="#">Add to Wishlist</a>
                                        </li>
                                        <li class="list-inline-item"><a class="color-white" href="#"><span
                                                        class="flaticon-share"> Share</span></a></li>
                                    </ul>
                                <?php endif ?>

                            </div>
                            <h3 class="cs_title color-white">
                                <?= e($model->title) ?>
                            </h3>

                            <ul class="cs_review_seller">

                                <li class="list-inline-item" style="<?= $model->isBestSeller ? '' : 'display:none' ?>">
                                    <a class="color-white" href="#">
                                        <span>Best Seller</span>
                                    </a>
                                </li>

                                <?= Yii::$app->help->stars($model->intvalAverageRating, '<li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>', '<li class="list-inline-item"><a href="#"><i class="fa fa-star-o"></i></a></li>') ?>

                                <li class="list-inline-item">
                                    <a class="color-white" href="#">
                                        <?= $model->averageRating ?>
                                        (<?= Yii::$app->formatter->asInteger($model->ratingsCount) ?> ta bahoga ko'ra)
                                    </a>
                                </li>
                            </ul>

                            <ul class="cs_review_enroll">
                                <li class="list-inline-item"><a class="color-white" href="#"><span
                                                class="flaticon-profile"></span> <?= Yii::$app->formatter->asInteger($model->enrolls_count) ?> <?= t('Students') ?>
                                    </a></li>

                                <?php if ($activeCommentsCount > 0): ?>
                                    <li class="list-inline-item"><a class="color-white" href="#"><span
                                                    class="flaticon-comment"></span>
                                            <?= $activeCommentsCount ?>
                                            <?= t('Reviews') ?></a></li>
                                <?php endif ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
