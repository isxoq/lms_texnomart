<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\form\ActiveForm;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\models\SignupForm */
?>
<div class="text-center">
    <h6 style="color: #555"><?= t('Enter the code sent to your phone number') ?></h6>
</div>
<?php  $form = ActiveForm::begin([
        'action' => ['signup/verify']
]) ?>
<?= $form->field($model, 'code')->widget('\yii\widgets\MaskedInput', [
    'mask' => '99999',
    'options' => [
        'autofocus' => true,
        'placeholder' => t('Verification code')
    ]
])->label( false);
?>
<?php  ActiveForm::end() ?>


