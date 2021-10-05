<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this backend\components\BackendView */
/* @var $model backend\models\Partner */
/* @var $form soft\kartik\SActiveForm */
?>

<div class="partner-form">

    <?php $form = SActiveForm::begin(); ?>

    <?= $form = SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'image:elfinder',
            'link',
            'status',
        ]
    ]); ?>

    <div class="form-group">
        <?= SHtml::submitButton() ?>
    </div>

    <?php SActiveForm::end(); ?>

</div>
