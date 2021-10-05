<?php

use soft\bs4\Card;
use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\File*/
/* @var $lesson frontend\modules\teacher\models\Lesson */
/* @var $upload soft\helpers\UploadHelper */

//$lessons = \frontend\modules\teacher\models\Lesson::find()->andWhere(['section_id' => $lesson->section_id])->all();

?>

<?php Card::begin([
    'header' => false
]) ?>
<?php $form = SActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>
<?= $form->errorSummary($model) ?>
<?= $form->errorSummary($upload) ?>
<div class="row">
    <div class="col-md-6">
        <?= SForm::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'title' => [
                    'options' => ['autofocus' => 'true']
                ],
            ]
        ]); ?>
        <?= SForm::widget([
            'model' => $upload,
            'form' => $form,
            'attributes' => [
                'file:fileInput'
            ]
        ]); ?>
        <?= SForm::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'status',
                /*'lesson_id:select2' => [
                    'visible' => !$model->isNewRecord,
                    'options' => [
                        'data' => \yii\helpers\ArrayHelper::map($lessons, 'id', 'title')
                    ]
                ]*/
            ]
        ]); ?>
    </div>
    <div class="col-md-6">
        <?= SForm::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'description:textarea' => [
                    'options' => ['rows' => 10]
                ],
            ]
        ]); ?>



    </div>
    <div class="form-group">
        <?= SHtml::submitButton() ?>
    </div>
</div>
<?php SActiveForm::end(); ?>
<?php Card::end() ?>


