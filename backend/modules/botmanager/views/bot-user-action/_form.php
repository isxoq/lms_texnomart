<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\botmanager\models\BotUserAction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bot-user-action-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bot_user_id')->textInput() ?>

    <?= $form->field($model, 'kurs_id')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
