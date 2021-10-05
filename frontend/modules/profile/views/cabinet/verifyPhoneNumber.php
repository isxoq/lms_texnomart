<?php

use kartik\widgets\ActiveForm;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\models\SignupForm */

$this->title = "Telefon raqamni tasdiqlash";
$this->params['breadcrumbs'][] = t("Signup");
$this->params['breadcrumbs'][] = ['label' => 'Shaxsiy kabinet', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4">

        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'code')->widget('\yii\widgets\MaskedInput', [
            'mask' => '99999',
            'options' => [
                'autofocus' => true,
                'placeholder' => t('Verification code')
            ]
        ])->hint('Telefon raqamingizga yuborilgan kodni kiriiting');
        ?>

        <button type="submit" class="btn btn-success">Kodni kiritish</button>
        <?php ActiveForm::end() ?>
    </div></div>