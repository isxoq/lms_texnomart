<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */

/* @var $model common\models\LoginForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = t('Login to the site');
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- Our LogIn Register -->
<section class="our-log bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="login_form inner_page">
                    <?php $form = ActiveForm::begin() ?>
                    <div class="heading">
                        <h3 class="text-center"><?= t('Enter your login and password to access the site') ?></h3>
                        <p class="text-center">
                            <?= t('Not registered yet?') ?>
                            <a class="text-thm" href="<?= to(['signup/index']) ?>">
                                <?= t('Register right now') ?>
                                !</a>
                        </p>
                    </div>
                    <?= $form->field($model, 'username')
                        ->textInput(['autofocus' => true])
                        ->label(t('Enter your phone number or email'))
                        ->hint("Telefon raqamingizni 998911234567 yoki 911234567 ko'rinishida kiriting.")

                    ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="form-group custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="exampleCheck3"
                               name="<?= Html::getInputName($model, 'rememberMe') ?>" value="1">
                        <label class="custom-control-label" for="exampleCheck3"><?= t('Remember me') ?></label>
                        <a class="tdu btn-fpswd float-right"
                           href="<?= to(['reset/index']) ?>">   <?= t('Forget Password?') ?></a>
                    </div>
                    <button type="submit" class="btn btn-log btn-block btn-thm2">
                        <?= t('Enter') ?>
                    </button>

                    <?php if (false): ?>
                        <div class="divide">
                            <span class="lf_divider">Or</span>
                            <hr>
                        </div>
                        <div class="row mt40">
                            <div class="col-lg">
                                <button type="submit" class="btn btn-block color-white bgc-fb mb0"><i
                                            class="fa fa-facebook float-left mt5"></i> Facebook
                                </button>
                            </div>
                            <div class="col-lg">
                                <button type="submit" class="btn btn2 btn-block color-white bgc-gogle mb0"><i
                                            class="fa fa-google float-left mt5"></i> Google
                                </button>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</section>