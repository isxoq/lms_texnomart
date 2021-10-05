<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;

/* @var $this \yii\web\View */
/* @var $model \frontend\modules\teacher\models\Media|\yii\db\ActiveRecord */
/* @var $lesson \frontend\modules\teacher\models\Lesson */
$lessons = $lesson->section->getLessons()->nonDeleted()->all();
?>

<div class="card card-default card-md mb-4 mt-4">
    <div class="card-body">
        <?php $form = SActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= SForm::widget([
                    'model' => $model,
                    'form' => $form,
                    'attributes' => [
                        'title' => [
                            'options' => ['autofocus' => 'true']
                        ],
                        'status',
                        'description:textarea' => [
                            'options' => ['rows' => 10]
                        ],
                        'lesson_id:select2' => [
                            'visible' => !$model->isNewRecord,
                            'options' => [
                                'data' => \yii\helpers\ArrayHelper::map($lessons, 'id', 'title')
                            ]
                        ]
                    ]
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= SForm::widget([
                    'model' => $model,
                    'form' => $form,
                    'attributes' => [
                        'poster:cropper' => [
                            'options' => [
                                'uploadUrl' => to(['media/uploadimage']),
                                'width' => 720,
                                'height' => 405,
                            ]
                        ],
                    ]
                ]); ?>
            </div>
        </div>
        <?php $label = $model->isNewRecord ? "Keyingisi <i data-feather='arrow-right-circle'></i>" : "Saqlash" ?>
        <div class="form-group">
            <?= SHtml::submitButton($label) ?>
        </div>
        <?php SActiveForm::end(); ?>
    </div>
</div>


