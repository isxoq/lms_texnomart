<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this backend\components\BackendView */
/* @var $model backend\modules\kursmanager\models\Enroll */
/* @var $form soft\kartik\SActiveForm */
?>

<div class="enroll-form">

    <?php $form = SActiveForm::begin(); ?>

    <?= $form = SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
              'user_id',
          'kurs_id',
          'status',
          'sold_price',
          'end_at',
          'type',
          'free_trial',
        ]
    ]); ?>

    <div class="form-group">
        <?= SHtml::submitButton() ?>
    </div>

    <?php SActiveForm::end(); ?>

</div>
