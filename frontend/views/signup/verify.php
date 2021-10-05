<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\widgets\ActiveForm;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\models\SignupForm */

$this->title = t("Verify phone number");
$this->params['breadcrumbs'][] = t("Signup");
$this->params['breadcrumbs'][] = $this->title;
?>


<section class="our-log bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="login_form inner_page">
                    <?php $form = ActiveForm::begin() ?>

                    <div class="heading">
                        <h3 class="text-center"><?= t('Enter the code sent to your phone number') ?></h3>
                    </div>

                    <?= $form->field($model, 'code')->widget('\yii\widgets\MaskedInput', [
                        'mask' => '99999',
                        'options' => [
                            'autofocus' => true,
                            'placeholder' => t('Enter verification code')
                        ]
                    ])->label( t('Verification code')); ?>

                    <button type="submit" class="btn btn-log btn-block btn-thm2">
                        <?= t('Kodni kiritish') ?>
                    </button>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</section>
