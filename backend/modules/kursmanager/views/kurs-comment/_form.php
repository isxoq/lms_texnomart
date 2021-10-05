<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \soft\web\SView */
/* @var $model backend\modules\kursmanager\models\KursComment */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'show_on_slider')->widget(\kartik\widgets\SwitchInput::class) ?>


<?php if (!$this->isAjax): ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php endif ?>

<?php ActiveForm::end(); ?>

