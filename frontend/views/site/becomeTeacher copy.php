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

<?php $form = ActiveForm::begin([
//    'id' => 'wrapped',
    'options' => [
        'class' => 'woocommerce-form woocommerce-form-login login',
        'enctype' => 'multipart/form-data',
    ]
]) ?>
<input id="website" name="website" type="text" value="">
<!-- Leave for security protection, read docs for details -->
<div id="middle-wizard">
    <div class="step">
        <div id="intro">
            <figure><img src="<?= settings('becomeTeacher', 'page_logo') ?>" alt=""></figure>
            <h1><?= settings('becomeTeacher', 'page_title') ?></h1>
            <p>
                <?= Yii::$app->formatter->asHtml(settings('becomeTeacher', 'page_text')) ?>
            </p>
        </div>
    </div>

    <div class="step">
        <h3 class="main_question"><strong>1/3</strong><?= t('Please fill with your details') ?></h3>

        <?= $form->field($model, 'firstname')
            ->textInput(['class' => 'form-control required', 'placeholder' => t('Your firstname')])
        ?>

        <?= $form->field($model, 'lastname')
            ->textInput(['class' => 'form-control required', 'placeholder' => t('Your lastname')])
        ?>

        <?= $form->field($model, 'age')
            ->textInput(['class' => 'form-control required', 'placeholder' => t('Your age')])
        ?>



        <?= $form->field($model, 'gender', [
            'options' => [
                'class' => 'form-group radio_input'
            ]
        ])->radioList([

            User::GENDER_MALE => t("Male"),
            User::GENDER_FEMALE => t("Female"),

        ], [
            'item' => function ($index, $label, $name, $checked, $value) {
                return "<label><input type='radio' value='{$value}' name='{$name}' class='icheck'>{$label}</label>";
            }
        ])->label(false) ?>


    </div>
    <!-- /step-->

    <div class="step">
        <h3 class="main_question"><strong>2/3</strong></h3>


        <?= $form->field($model, 'education_level_id', [
            'options' => ['class' => 'form-group select'],
            'template' => "{label}\n<div class='styled-select'>{input}\n{error}</div>",
            'inputOptions' => ['class' => 'required'],
            'addClass' => 'required',
        ])->dropDownList($educationLevelMap, [
            'prompt' => t('Select') . " ...",
        ])->label(t('Select your education level')) ?>



        <?= $form->field($model, 'address')->textarea(['style' => ['height' => '100px']])->label(t('Enter your address')) ?>


    </div>
    <!-- /step-->

    <div class="submit step">
        <h3 class="main_question"><strong>3/3</strong></h3>


        <div class="form-group add_top_30">
            <?= $form->field($model, 'message', [
                'template' => "{label}\n{input}\n{error}"
            ])->textArea([
                'style' => ['height' => '120px'],
                'class' => 'form-control required'
            ])
            ?>
        </div>

        <?= $form->field($upload, 'file')->fileInput()->label(t('Attach your reference resume')) ?>

        <br><br>

        <?= $form->field($model, 'accept_terms_and_conditions')->checkbox([

            'id' => 'accept-checkbox',
            'class' => 'icheck required',
            'style' => 'margin-top:0px;',
            'labelOptions' => ['tag' => 'label'],
            'label' => "<label for='accept-checkbox'><a href='#' data-toggle='modal' data-target='#terms-txt'>"
                . t('Accept terms and conditions') . "</a></label>",


        ]) ?>


    </div>
    <!-- /step-->
</div>
<!-- /middle-wizard -->
<div id="bottom-wizard">
    <button type="button" name="backward" class="backward"><?= t('Backward') ?></button>
    <button type="button" name="forward" class="forward"><?= t('Forward') ?></button>
    <button type="submit" name="process" class="submit"><?= t('Submit') ?></button>
</div>
<!-- /bottom-wizard -->
<?php ActiveForm::end() ?>


<!-- Modal terms -->
<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="termsLabel"><?= t('Terms and conditions') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <?= settings('becomeTeacher',  'terms_and_conditions' ) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn_1" data-dismiss="modal"><?= t('Close') ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


