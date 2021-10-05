<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \backend\modules\profilemanager\models\ChangePasswordForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\password\PasswordInput;

$this->title = t('Set new password');
$this->params['breadcrumbs'][] = $this->title;

$css = <<<CSS

  .custom-password-input{
    border-radius: 5px 0 0 5px!important;
  }
  
  .set-new-password-form .input-group .input-group-append{
        height: 50px;
  }

    td.kv-meter-container{
        width: 0!important;
    }

CSS;
$this->registerCss($css);

?>


<section class="our-log bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 offset-lg-3">
                <div class="login_form inner_page">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'set-new-password-form'
                        ]
                    ]) ?>
                    <div class="heading">
                        <h3 class="text-center"><?= $this->title ?></h3>
                    </div>

                    <?= $form->field($model, 'password')->widget(PasswordInput::classname(), [
                        'pluginOptions' => [
                            'showMeter' => false,
                        ],
                        'options' => [
                            'class' => 'form-control custom-password-input'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'repassword')->widget(PasswordInput::classname(), [
                        'pluginOptions' => [
                            'showMeter' => false,
                        ],
                        'options' => [
                            'class' => 'form-control custom-password-input'
                        ]
                    ]); ?>

                    <button type="submit" class="btn btn-log btn-block btn-thm2">
                        <?= t('Kiritish') ?>
                    </button>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</section>

