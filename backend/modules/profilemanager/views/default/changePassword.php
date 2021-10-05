<?php

use yii\helpers\Html;
use soft\kartik\SDetailView;
use kartik\builder\Form;

/* @var $this backend\components\BackendView */

$this->title = t('Change password');
$this->params['breadcrumbs'][] = ['label' =>  t('Personal cabinet'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="row">
    <div class="col-md-6">
        <?php $form = \kartik\widgets\ActiveForm::begin(); ?>
        <?= Form::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'password' => [
                    'type' => Form::INPUT_PASSWORD
                ],
                'repassword' => [
                    'type' => Form::INPUT_PASSWORD
                ],
            ],
        ]);

        ?>

        <div class="form-group">
            <?= \soft\helpers\SHtml::submitButton() ?>
        </div>

        <?php \kartik\widgets\ActiveForm::end(); ?>
    </div>
</div>
