<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model backend\modules\contactmanager\models\Contact */

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = t('Contacts');
$this->params['breadcrumbs'][] = t('Contacts');
$settings = Yii::$app->settings;

?>

<section class="our-contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-placeholder-1"></span></div>
                    <h4><?= t('Company Office Address') ?></h4>
                    <p><?= $settings->get('site', 'company_address') ?></p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-phone-call"></span></div>
                    <h4><?= t('Phone number') ?></h4>
                    <p class="mb0"><?= $settings->get('site', 'company_phone_number') ?></p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-email"></span></div>
                    <h4><?= t('Email address') ?></h4>
                    <p><?= $settings->get('site', 'company_email') ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="h600" id="map-canvas">
                    <?= $settings->get('site', 'company_address_map_embed') ?>
                </div>
            </div>
            <div class="col-lg-6 form_grid">
                <h4 class="mb5"><?= t('Send a message') ?></h4>
                <p><?= t('Send message text on contact page') ?></p>
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'contact_form']
                ]) ?>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <?= $form->field($model, 'firstname')->textInput(['autofocus' => true])->label(t('Your firstname')) ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?= $form->field($model, 'lastname')->textInput()->label(t('Your lastname')) ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?= $form->field($model, 'email')->textInput(['type' => 'email'])->label(t('Email')) ?>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?= $form->field($model, 'phone')->widget(\soft\widget\PhoneMaskedInput::class, [
                            'options' => [
                                'placeholder' => '+998(__) ___-__-__',
                            ]
                        ])->label(t('Email')) ?>
                    </div>

                    <div class="col-sm-12">
                        <?= $form->field($model, 'body')->textarea()->label(t('Your message')) ?>

                    </div>

                    <div class="col-sm-12">
                        <?= $form->field($model, 'captcha')->widget(Captcha::class, [
                            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                            'options' => [
                                'placeholder' => t('Enter the verification code')
                            ]
                        ])->label('Tekshiruv kodi') ?>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn dbxshad btn-lg btn-thm circle white">
                            <?= t('Send message button text') ?>
                        </button>
                    </div>

                </div>

                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</section>

