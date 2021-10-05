<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;
use soft\bs4\Card;


/* @var $this backend\components\BackendView */
/* @var $model frontend\modules\teacher\models\Section */
/* @var $form soft\kartik\SActiveForm */
$isAjax = $this->isAjax;
?>

<?php if (!$isAjax): ?>
    <?php Card::begin([
        'header' => false
    ]) ?>
<?php endif; ?>
<?php $form = SActiveForm::begin(); ?>
<?= $form = SForm::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'title',
        'status:checkbox:Faol',
    ]
]); ?>
<?php if (!$isAjax): ?>
    <div class="form-group">
        <?= SHtml::submitButton() ?>
    </div>
<?php endif ?>
<?php SActiveForm::end(); ?>
<?php if (!$isAjax): ?>
    <?php Card::end() ?>
<?php endif; ?>

