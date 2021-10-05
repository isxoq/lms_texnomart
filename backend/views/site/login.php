<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = t('Enter');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>


<section class="login-block">
    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>


                <form class="md-float-material form-material">
                    <!--                    <div class="text-center">-->
                    <!--                        <img src="../files/assets/images/logo.png" alt="logo.png">-->
                    <!--                    </div>-->
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-center"><?= t('Administration') ?></h3>
                                </div>
                            </div>
                            <?= $form
                                ->field($model, 'username')
                                ->label(false)
                                ->textInput(['placeholder' => t('Login')]) ?>
                            <?= $form
                                ->field($model, 'password')
                                ->label(false)
                                ->passwordInput(['placeholder' => t('Password')]) ?>
                            <div class="row m-t-25 text-left">
                                <div class="col-12">
                                    <div class="col-xs-8">
                                        <?= $form->field($model, t('rememberMe'))->checkbox()->label(t('Remember me')) ?>
                                    </div>
                                    <div class="forgot-phone text-right f-right">
                                        <a href="auth-reset-password.html" class="text-right f-w-600"> Forgot
                                            Password?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <?= Html::submitButton(t('Enter'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-10">
                                    <p class="text-inverse text-left m-b-0">Thank you.</p>
                                    <p class="text-inverse text-left"><a href="index.html"><b class="f-w-600">Back
                                                to website</b></a></p>
                                </div>
                                <!--                                <div class="col-md-2">-->
                                <!--                                    <img src="../files/assets/images/auth/Logo-small-bottom.png"-->
                                <!--                                         alt="small-logo.png">-->
                                <!--                                </div>-->
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>

                    <!-- end of form -->
            </div>
            <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>
