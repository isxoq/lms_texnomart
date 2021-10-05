<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\frontendmanager\models\IndexInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="index-info-form">

<?php $form = SActiveForm::begin(); ?>

    <?= SForm::widget([
                                'model' => $model,
                                'form' => $form,
                                'attributes' => [
                                    'title',
                                    'content:textarea',

                                    'icon',
                                    'status',
                                ],

                            ]); ?>

    <div class="form-group">
        <?= SHtml::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php SActiveForm::end(); ?>

</div>
