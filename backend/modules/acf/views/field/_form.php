<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\acf\models\FieldType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\acf\models\Field */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">

    <div class="col-md-6">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(FieldType::find()->all(), 'id', 'name')) ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'character_limit')->textInput(['type' => 'number']) ?>


        <?= $form->field($model, 'is_required')->checkbox() ?>

        <?= $form->field($model, 'is_multilingual')->checkbox() ?>

        <?= $form->field($model, 'is_active')->checkbox(['label' => Yii::t('app', 'Is Active')])->label(false) ?>


    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'options')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'placeholder')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'prepend')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'append')->textInput(['maxlength' => true]) ?>



    </div>




</div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>