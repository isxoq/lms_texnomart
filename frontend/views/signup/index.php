<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\widgets\ActiveForm;

/** @var frontend\components\FrontendView $this */
/** @var frontend\models\SignupForm $model */

$this->title = t('Register');
$this->params['breadcrumbs'][] = $this->title;

$settings = Yii::$app->settings;

?>

<!-- Our LogIn Register -->
<section class="our-log bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="login_form inner_page">
                    <?php $form = ActiveForm::begin() ?>

                    <div class="heading">
                        <h3 class="text-center"><?= t('Register') ?></h3>
                        <p class="text-center">
                            <?= t('Already have an acccount?') ?>
                            <a class="text-thm"  href="<?= to(['site/login']) ?>"><?= t('Log in to the site') ?>!</a>
                        </p>
                    </div>
                    <?= $form->field($model, 'phone')->widget('\soft\widget\PhoneMaskedInput') ?>


                    <button type="submit" class="btn btn-log btn-block btn-thm2">
                        <?= t('Register') ?>
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
