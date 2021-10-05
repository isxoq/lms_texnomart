<?php


use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Update');

$this->title = Yii::t('app', 'Sms settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sms manager'), 'url' => ['/smsmanager']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sms settings'), 'url' => ['/smsmanager/default/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="attribute-group-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php  $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'value') ?>

    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

    </div>

    <?php  ActiveForm::end() ?>


</div>

