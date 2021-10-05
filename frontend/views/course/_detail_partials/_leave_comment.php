<?php

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 10:00
 */

use backend\models\Rating;
use kartik\form\ActiveForm;
use kartik\rating\StarRating;

/* @var $this \soft\web\SView */
/* @var $model \frontend\models\Kurs */

$rating = Rating::findOrCreateModel($model->id);
$comment = new \backend\modules\kursmanager\models\KursComment([
    'scenario' => 'leave_comment'
]);
$this->registerCss('
.clear-rating{
    margin-top:9px;
}
.rating-md {
    font-size: inherited;
}

');


?>

<div class="cs_row_seven csv2">
    <div class="sfeedbacks">
        <div class="mbp_comment_form style2 pb0">
            <h4>Fikr bildirish</h4>

            <?php $form = ActiveForm::begin([
                'action' => to(['leave-comment', 'id' => $model->slug]),
                'options' => ['class' => 'comments_form']
            ]) ?>
            <?= $form->field($rating, 'rate')->label('Sizning bahoingiz')->widget(StarRating::classname(), [
                'pluginOptions' => [
                    'filledStar' => '<i class="fa fa-star fz18"></i>',
                    'emptyStar' => '<i class="fa fa-star-o fz18"></i>',
                    'clearButton' => '<i class="fa fa-minus-circle fz18"></i>',
                    'step' => 1,
                    'starCaptions' => [
                        0 => 'Baholanmagan',
                        1 => 'Juda yomon',
                        2 => 'Yomon',
                        3 => 'Qoniqarli',
                        4 => 'Yaxshi',
                        5 => "A'lo darajada",
                    ],
                ]
            ]); ?>
            <?= $form->field($comment, 'text')->textarea(['rows' => 6, 'placeholder' => 'Fikringizni yozing']) ?>

            <button type="submit" class="btn btn-thm">Saqlash <span
                        class="flaticon-right-arrow-1"></span></button>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

