<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\octouz\models\Octouz */
/* @var $form ActiveForm */
?>
<div class="update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shop_id') ?>
    <?= $form->field($model, 'auto_capture')->dropDownList([
        0 => Yii::t('app', 'OFF'),
        1 => Yii::t('app', 'ON'),
    ]) ?>
    <?= $form->field($model, 'test')->dropDownList([
        0 => Yii::t('app', 'Test Payment OFF'),
        1 => Yii::t('app', 'Test Payment ON'),
    ]) ?>
    <?= $form->field($model, 'secret') ?>
    <?= $form->field($model, 'return_url') ?>
    <?= $form->field($model, 'notify_url') ?>
    <?= $form->field($model, 'ttl')->textInput([
        'placeholder' => " ... minutes"
    ]) ?>
    <?= $form->field($model, 'currency')->dropDownList([
        'UZS' => Yii::t('app', 'UZS'),
        'USD' => Yii::t('app', 'USD'),
    ]) ?>
    <?= $form->field($model, 'status')->dropDownList([
        0 => Yii::t('app', 'Deactivate'),
        1 => Yii::t('app', 'Active'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- update -->
