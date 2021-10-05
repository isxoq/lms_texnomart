<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\models\LoginForm */


?>
<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'login-form'
    ]
]) ?>
<?= $form->field($model, 'username')
    ->textInput(['autofocus' => true])
    ->label(t('Enter your email or phone number'))
    ->hint("Telefon raqamingizni 998911234567 yoki 911234567 ko'rinishida kiriting.")
;
?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="exampleCheck3"
           name="<?= Html::getInputName($model, 'rememberMe') ?>" value="1">
    <label class="custom-control-label" for="exampleCheck3"><?= t('Remember me') ?></label>

</div>
<?php ActiveForm::end() ?>
<div class="text-center add_top_10">
    <?= t('Not registered yet?') ?>
    <br>
    <strong>
        <a href="<?= to(['signup/index']) ?>" class="text-thm" role="modal-remote"><?= t('Register right now') ?>!</a>
    </strong>
</div>
<div class="text-center">
    <?= t('Forget Password?') ?>
    <br>
    <strong>
        <a href="<?= to(['reset/index']) ?>" class="text-danger" data-pjax="0"><?= t('Reset password') ?>!</a>
    </strong>
</div>
