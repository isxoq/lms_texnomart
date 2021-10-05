<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\form\ActiveForm;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\models\SignupForm */
?>

<?php  $form = ActiveForm::begin() ?>
<?= $form->field($model, 'phone')->widget('\soft\widget\PhoneMaskedInput', [
    'options' => [
        'autofocus' => true,

    ]
]) ?>
<?php  ActiveForm::end() ?>
<div class="text-center add_top_10">
    <?= t('Already have an acccount?') ?>
    <br>
    <strong>
        <a href="<?= to(['site/login']) ?>" class="text-thm" role="modal-remote"><?= t('Log in to the site') ?>!</a>
    </strong>
</div>

