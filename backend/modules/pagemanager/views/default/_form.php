<?php

use kartik\switchinput\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yeesoft\multilingual\widgets\ActiveForm;
use soft\kartik\SActiveForm;


?>

<div class="page-form">

    <?php $form = SActiveForm::begin(); ?>
    <?= $form->languageSwitcher($model) ?>

    <?= \soft\form\SForm::widget([
        'form' => $form,
        'model' => $model,
        'attributes' => [
            'title',
            'idn',
            'description' => [
                'type' => \soft\service\InputType::WIDGET,
                'widgetClass' => CKEditor::className(),
                'options' => [

                    'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder',[
                        'extraAllowedContent' => "h1(*);h2(*);span",
                    ]),
                ]

            ],

            'status',

        ]
    ]) ?>
    <?= \soft\helpers\SHtml::submitButton() ?>
    <?php SActiveForm::end(); ?>

</div>