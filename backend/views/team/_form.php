<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this backend\components\BackendView */
/* @var $model backend\models\Team */
/* @var $form soft\kartik\SActiveForm */

?>
<i class="fa fa-send"></i>
<div class="team-form">

    <?php $form = SActiveForm::begin(); ?>

    <?= $form = SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'fullname',
            'position',
            'status',
            'image:cropper' => [
                'options' => [
                    'uploadUrl' => to(['team/upload-image']),
                    'width' => 370,
                    'height' => 370,
                ]
            ],
            'socials' => [
                'type' => SForm::INPUT_TEXTAREA
            ],
        ]
    ]); ?>

    <div class="form-group">
        <?= SHtml::submitButton() ?>
    </div>

    <?php SActiveForm::end(); ?>

</div>
