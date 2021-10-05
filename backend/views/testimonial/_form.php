<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;
use common\models\User;

$array = User::find()->select(['id', 'firstname','lastname'])->asArray()->all();
$map = map($array, 'id', function ($model){
    return $model['firstname'] . " ". $model['lastname'];
});

/* @var $this backend\components\BackendView */
/* @var $model backend\models\Testimonial */
/* @var $form soft\kartik\SActiveForm */
?>

<div class="testimonial-form">

    <?php $form = SActiveForm::begin(); ?>

    <?= $form = SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'title',
            'text:textarea',
            'user_id:select2' => [
                    'options' => [
                            'data' => $map,
                    ]
            ],
            'status',
        ]
    ]); ?>

    <div class="form-group">
        <?= SHtml::submitButton() ?>
    </div>

    <?php SActiveForm::end(); ?>

</div>
