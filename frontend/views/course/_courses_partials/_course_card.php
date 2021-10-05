<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 14:38
 */

/** @var \frontend\models\Kurs $model */
/* @var $this \frontend\components\FrontendView */
$detailUrl = $model->detailUrl;
?>

<div class="top_courses">
    <div class="thumb">
        <img class="img-whp" src="<?= $model->kursImage ?>"
             alt="<?= $model->title ?>"
             style="height: 200px; width: 100%; object-fit: cover">
        <a href="<?= $detailUrl ?>" data-pjax="0">
            <div class="overlay">
                <?php if ($model->enrolls_count > 50): ?>
                    <div class="tag">Best Seller</div>
                <?php endif ?>
                
                <?php if (!$model->is_free && $model->hasDiscount): ?>
                    <div class="icon discount-badge" >
                        <span class="badge badge-primary">-<?= $model->discountPercent ?>%</span>
                    </div>
                <?php endif ?>
                
                <span class="tc_preview_course"
                   href="<?= $detailUrl ?>" data-pjax="0"><?= t('Preview course') ?></span>
            </div>
        </a>
    </div>
    <div class="details">
        <div class="tc_content">
            <p align="center"><?= e($model->user['firstname'] . " " . $model->user['lastname']) ?></p>
            <h5 style="min-height: 52px" align="center">
                <a href="<?= $detailUrl ?>" data-pjax="0">
                    <?= e($model->title) ?>
                </a>
            </h5>
            <ul class="tc_review" style="min-height: 25px; display: flex; justify-content: center">
                <?php
                $star = '<i class="fa fa-star"></i>';
                $emptyStar = '<i class="fa fa-star-o"></i>';
                $rating = $model->getAverageRating();
                $starsCount = intval($rating);
                $remainStarsCount = 5 - $starsCount;
                ?>

                <?php if ($rating > 0): ?>
                        <?php for ($i = 1; $i <= $starsCount; $i++): ?>
                            <li class="list-inline-item"><a><i
                                            class="fa fa-star"></i></a></li>
                        <?php endfor ?>
                        <?php for ($i = 1; $i <= $remainStarsCount; $i++): ?>
                            <li class="list-inline-item"><a><i
                                            class="fa fa-star-o"></i></a></li>
                        <?php endfor ?>
                        <li class="list-inline-item">
                            <a href="#">
                                <b><?= $rating ?></b>
                                (<?= $model->getRatingsCount() ?> ta baho)
                            </a>
                        </li>
                <?php endif ?>

            </ul>
        </div>
        <div class="tc_footer">
            <ul class="tc_meta float-left">
                <li class="list-inline-item"><a href="#"><i
                                class="flaticon-profile"></i></a></li>
                <li class="list-inline-item"><a
                            href="#"><?= intval($model->enrolls_count) ?></a>
                </li>
                <li class="list-inline-item"><a href="#"><i
                                class="flaticon-comment"></i></a></li>
                <li class="list-inline-item"><a href="#">
                        <?= $model->getActiveCommentsCount() ?>
                    </a></li>
            </ul>
            <div class="tc_price float-right">
                <?= $model->formattedPrice ?>
            </div>
        </div>
    </div>
</div>
