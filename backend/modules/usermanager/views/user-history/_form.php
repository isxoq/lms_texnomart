<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\usermanager\models\UserHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-history-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'url')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'prev_url')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'page_title')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'device')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'device_type')->dropDownList(\backend\modules\usermanager\models\UserHistory::deviceTypes()) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
