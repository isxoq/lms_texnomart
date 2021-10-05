<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\settings\models\Settings;

/* @var $this yii\web\View */
/* @var $model backend\modules\settings\models\Settings */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Yangi qo`shish';
$this->params['breadcrumbs'][] = ['label' => "Sozlamalar", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="settings-form">

    <?php $form = ActiveForm::begin([
            'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id]
    ]); ?>

    <?= $form->field($model, 'type')->dropDownList(Settings::getTypes()) ?>

    <?= $form->field($model, 'section')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
