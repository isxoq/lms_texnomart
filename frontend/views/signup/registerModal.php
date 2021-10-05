<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\form\ActiveForm;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\models\SignupForm */
?>


<?php  $form = ActiveForm::begin([
    'action' => ['signup/register']
]) ?>

<?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'lastname') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_repeat')->passwordInput() ?>

<?php  ActiveForm::end() ?>
