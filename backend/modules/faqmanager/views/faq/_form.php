<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \backend\components\BackendView */
/* @var $model backend\modules\faqmanager\models\FaqCategory */
/* @var $form yii\widgets\ActiveForm */


?>

<?php $form = \soft\kartik\SActiveForm::begin() ?>

<?= \soft\form\SForm::widget([

    'form' => $form,
    'model' => $model,
    'attributes' => [
        'category_id:select2' => [
            'options' => [
                'data' => map(\backend\modules\faqmanager\models\FaqCategory::getAll(), 'id', 'title'),
            ],
        ],
        'title',
        'text:ckeditor' => [
            'options' => [
                'editorOptions' => [
                    'preset' => 'basic',
                ]
            ]

        ],
        'status',

    ]
]) ?>

<?= \soft\helpers\SHtml::submitButton(null, ['visible' => !$this->isAjax]) ?>

<?php \soft\kartik\SActiveForm::end() ?>

