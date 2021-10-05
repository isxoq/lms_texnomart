<?php

use kartik\widgets\ActiveForm;

/** @var frontend\components\FrontendView $this */
/** @var frontend\models\SignupForm $model */

$this->title = "Telefon raqamni kiritish";
$this->params['breadcrumbs'][] = ['label' => 'Shaxsiy kabinet', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="row">
    <div class="col-md-4">
        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'phone')->widget('\soft\widget\PhoneMaskedInput') ?>

        <button type="submit" class="btn btn-success">Kiritish</button>

        <?php ActiveForm::end() ?>
    </div></div>