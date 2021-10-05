<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;

/* @var $this soft\web\SView */
/* @var $model backend\models\Social */
/* @var $form SActiveForm */
?>
<?php $form = SActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <?= SForm::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'name',
                'icon',
                'url',
                'status',
            ],
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <?= SHtml::submitButton() ?>
</div>
<?php SActiveForm::end(); ?>