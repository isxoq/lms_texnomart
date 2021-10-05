<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use kartik\widgets\ActiveForm;
use backend\models\EducationLevel;
use yii\helpers\ArrayHelper;
use soft\helpers\SHtml;
use common\models\User;


/* @var $this frontend\components\FrontendView */
/* @var $model frontend\models\BecomeTeacherForm */
/* @var $upload soft\helpers\UploadHelper */

$this->title = t('Become Instructor');
$educationLevelMap = ArrayHelper::map(EducationLevel::find()->all(), 'id', 'name');
?>


<!-- Our LogIn Register -->
<section class="our-log bgc-fa">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="login_form inner_page">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
                    ]) ?>
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 offset-lg-3">
                            <div class="heading">
                                <h3 class="text-center"><?= settings('becomeTeacher', 'page_title') ?></h3>
                                <p class="text-center">
                                    <?= Yii::$app->formatter->asHtml(settings('becomeTeacher', 'page_text')) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'firstname')
                                ->textInput(['placeholder' => t('Your firstname')])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'lastname')
                                ->textInput(['placeholder' => t('Your lastname')])
                            ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'age')
                                ->input('number', ['placeholder' => t('Your age')])
                            ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'gender')->radioList([
                                User::GENDER_MALE => t("Male"),
                                User::GENDER_FEMALE => t("Female"),
                            ])->label(t('Jinsingiz')) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'education_level_id')->dropDownList($educationLevelMap, [
                                'prompt' => t('Select') . " ...",
                            ])->label(t('Select your education level')) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'address')->label(t('Enter your address')) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'message')->textarea(['rows' => 5, 'style' => ['height' => '100px']]) ?>

                            <?= $form->field($model, 'speciality') ?>

                            <?= $form->field($model, 'is_ready')->radioList([
                                1 => 'Ha',
                                0 => "Yo'q"
                            ]) ?>


                            <?= $form->field($upload, 'file')->fileInput()->label(t('Attach your reference resume')) ?>
                            <?= $form->field($model, 'accept_terms_and_conditions')->checkbox([

                                'id' => 'accept-checkbox',
                                'labelOptions' => ['tag' => 'label'],
                                'label' => "<label for='accept-checkbox'><a href='#' data-toggle='modal' data-target='#terms-txt'>"
                                    . t('Accept terms and conditions') . "</a></label>",

                            ]) ?>
                        </div>

                    </div>
                    <p align="center">
                        <button type="submit" class="btn btn-lg btn-primary">
                            <?= t("Ma'lumotlarni saqlash") ?>
                        </button>
                    </p>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal terms -->
<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="termsLabel"><?= t('Terms and conditions') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <?= settings('becomeTeacher', 'terms_and_conditions') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= t('Close') ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


