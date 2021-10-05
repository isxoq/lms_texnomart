<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\widgets\ActiveForm;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\models\SignupForm */

$this->title = t('Register');
$this->params['breadcrumbs'][] = $this->title;

?>


<section class="our-log bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="login_form inner_page">
                    <?php $form = ActiveForm::begin() ?>

                    <div class="heading">
                        <h3 class="text-center"><?= t('Register') ?></h3>
                    </div>

                    <?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'lastname') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                    <button type="submit" class="btn btn-log btn-block btn-thm2">
                        <?= t('Register') ?>
                    </button>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</section>
