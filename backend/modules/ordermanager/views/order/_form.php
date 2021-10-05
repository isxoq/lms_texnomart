<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this backend\components\BackendView */
/* @var $model backend\modules\ordermanager\models\Order */
/* @var $form soft\kartik\SActiveForm */
?>

<div class="order-form">

    <?php $form = SActiveForm::begin(); ?>

    <?= $form = SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
              'user_id',
          'status',
        ]
    ]); ?>

    <div class="form-group">
        <?= SHtml::submitButton() ?>
    </div>

    <?php SActiveForm::end(); ?>

</div>
