<?php

use yii\helpers\Html;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */

$this->title = t('Update');
$this->params['breadcrumbs'][] = ['label' =>  t('Personal cabinet'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="social-form">

    <?php $form = \soft\kartik\SActiveForm::begin(); ?>
    <?= \soft\form\SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'username',
            'lastname',
            'firstname',
            'email',
        ],
    ]);

    ?>

    <div class="form-group">
        <?= \soft\helpers\SHtml::submitButton() ?>
    </div>

    <?php \soft\kartik\SActiveForm::end(); ?>

</div>
