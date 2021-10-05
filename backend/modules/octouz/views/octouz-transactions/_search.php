<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\octouz\models\OctouzTransactionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="octouz-transactions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'shop_transaction_id') ?>

    <?= $form->field($model, 'octo_payment_UUID') ?>

    <?= $form->field($model, 'octo_pay_url') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'error') ?>

    <?php // echo $form->field($model, 'errorMessage') ?>

    <?php // echo $form->field($model, 'transfer_sum') ?>

    <?php // echo $form->field($model, 'refunded_sum') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
