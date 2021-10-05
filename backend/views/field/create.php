<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;



?>

<div class="field-create">
    <div class="field-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'type')->dropDownList([ 'Qisqa matn' => 'Qisqa matn', 'Rasm' => 'Rasm', 'Katta matn' => 'Katta matn', 'Tel' => 'Tel', ]) ?>

    <?= $form->field($model, 'url') ?>
    <?= $form->field($model, 'status')->dropDownList([ 'Faol' => 'Faol', 'Nofaol' => 'Nofaol']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
</div>
