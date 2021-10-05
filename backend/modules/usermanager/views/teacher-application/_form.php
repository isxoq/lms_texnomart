<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;

use backend\modules\usermanager\models\TeacherApplication;

/* @var $this backend\components\BackendView */
/* @var $model \backend\modules\usermanager\models\TeacherApplication */
/* @var $form soft\kartik\SActiveForm */
?>

<div class="teacher-application-form">

    <?php $form = SActiveForm::begin(); ?>

    <?= $form = SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'comment:textarea',
            'status:dropdownList' => [
                'label' => 'Holat',
                'items' => [
                    TeacherApplication::STATUS_ACCEPTED => 'Tasdiqlangan',
                    TeacherApplication::STATUS_WAITING => 'Kutish rej.',
                    TeacherApplication::STATUS_CANCELLED => 'Bekor qilingan',
                ]
            ]
        ]
    ]); ?>

    <?php if (!$this->isAjax): ?>
        <div class="form-group">
            <?= SHtml::submitButton() ?>
        </div>
    <?php endif ?>

    <?php SActiveForm::end(); ?>

</div>
