<?php

use soft\helpers\SHtml;
use kartik\widgets\ActiveForm;
use backend\modules\settings\models\Settings;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\settings\models\Settings */
$this->title = 'Asosiy ma\'lumotlar - Yangi qo\'shish';

?>
<?php $form = ActiveForm::begin([
    'action' => ['create']
]); ?>
<?= $form->field($model, 'section')->textInput(['autofocus' => true, 'maxlength' => true, 'required' => true]) ?>
<?= $form->field($model, 'description')->textInput(['maxlength' => true, 'required' => true]) ?>
<?= $form->field($model, 'key') ?>
<?= $form->field($model, 'type')->dropDownList(Settings::getTypes()) ?>
<?= $form->field($model, 'is_multilingual')->checkbox()?>
<div class="form-group">
    <?= SHtml::submitButton(null, ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>
