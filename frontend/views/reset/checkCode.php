<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = t('Request password reset');
$this->params['breadcrumbs'][] = $this->title;

?>

    <section class="our-log bgc-fa">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-6 offset-lg-3">
                    <div class="login_form inner_page">
                        <?php $form = ActiveForm::begin() ?>
                        <div class="heading">
                            <h3 class="text-center"><?= $this->title ?></h3>
                        </div>

                        <?= $form->field($model, 'code')->widget('\yii\widgets\MaskedInput', [
                            'mask' => '99999',
                            'options' => [
                                'autofocus' => true,
                                'placeholder' => t('Verification code')
                            ]
                        ])->label( t('Enter the code sent to your phone number'));
                        ?>

                        <button type="submit" class="btn btn-log btn-block btn-thm2">
                            <?= t('Kiritish') ?>
                        </button>

                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
