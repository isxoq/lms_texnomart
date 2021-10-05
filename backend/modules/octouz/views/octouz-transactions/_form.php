<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\octouz\models\OctouzTransactions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="octouz-transactions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shop_transaction_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'octo_payment_UUID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'octo_pay_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'error')->textInput() ?>

    <?= $form->field($model, 'errorMessage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transfer_sum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refunded_sum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
