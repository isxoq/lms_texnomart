<?php

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 16:13
 */

/* @var $this \yii\web\View */
/* @var $model \frontend\models\Kurs|\yii\db\ActiveRecord */
/* @var $ratings \backend\models\Rating[] */

$totalRating = 0;
$totalRatingsCount = count($ratings);

$stars = [

    5 => 0,
    4 => 0,
    3 => 0,
    2 => 0,
    1 => 0,

];

foreach ($ratings as $rating) {

    $rate = $rating->rate;
    $totalRating += $rate;
    if (isset($stars[$rate])) {
        $stars[$rate]++;
    }

}
$averageRating = round($totalRating / $totalRatingsCount, 1);

$intvalAverageRating = intval(round($averageRating, 0));
$remainRating = 5 - $intvalAverageRating;

?>

<div class="cs_row_five csv2">
    <div class="student_feedback_container">
        <h4 class="aii_title">Baholar</h4>
        <div class="s_feeback_content">

            <?php foreach ($stars as $rate => $count): ?>

                <?php
                $width = $count / $totalRatingsCount * 100;
                ?>

                <ul class="skills">
                    <li class="list-inline-item"><?= $rate ?> baho</li>
                    <li class="list-inline-item progressbar1" data-width="<?= $width ?>"
                        data-target="100"> <?= $count > 0 ? ' ' . $count . ' ta' : '' ?>
                    </li>
                </ul>
            <?php endforeach; ?>
        </div>
        <div class="aii_average_review text-center">
            <div class="av_content">
                <h2><?= $averageRating ?></h2>
                <ul class="aii_rive_list mb0">

                    <?= Yii::$app->help->stars($intvalAverageRating, ' <li class="list-inline-item"><i class="fa fa-star"></i></li>', ' <li class="list-inline-item"><i class="fa fa-star-o"></i></li>') ?>


                </ul>
                <p>O'rtacha reyting</p>
            </div>
        </div>
    </div>
</div>

