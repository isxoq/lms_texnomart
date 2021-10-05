<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;
use backend\modules\kursmanager\models\Kurs;
use yii\helpers\ArrayHelper;


/* @var $this backend\components\BackendView */
/* @var $model backend\modules\frontendmanager\models\CourseSlider */
/* @var $form soft\kartik\SActiveForm */
?>


<?php $form = SActiveForm::begin(); ?>

<?= \soft\form\SFormGrid::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'autoGenerateColumns' => false,
    'rows' => [
        [
            'attributes' => [


                'title',
                'text',
                'course_id:select2' => [
                    'options' => [
                        'data' => ArrayHelper::map(Kurs::find()->with('user')->all(), 'id', function ($model) {

                            return $model->title . " (" . $model->user->fullname . ")";

                        }),
                    ]
                ],
                'icon',

                'image:elfinder',
                'little_image:elfinder',
                'status',
            ],
        ]

    ]


]); ?>

<div class="form-group">
    <?= SHtml::submitButton() ?>
</div>

<?php SActiveForm::end(); ?>

