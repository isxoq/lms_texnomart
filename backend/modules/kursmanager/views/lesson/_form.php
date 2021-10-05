<?php

use soft\kartik\SActiveForm;
use soft\form\SForm;
use backend\modules\kursmanager\models\Lesson;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Section */
/* @var $form soft\kartik\SActiveForm */

?>



<?php $form = SActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<div class="row">
    <div class="col-md-12">
        <?= SForm::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'title',
                'type:dropdownList' => [
                    'visible' => $model->isNewRecord || $model->isTaskLesson,
                    'items' => Lesson::getTypesList(),
                ],
                'description:textarea',
                'status:checkbox:Faol' => [
//                    'visible' => $model->hasMedia
                ],
                'is_open:checkbox' => [
                        'label' => "Oldindan ko'rishga ruxsat berish",
                ],
                /*'media_poster:fileInput' => [
                    'label' => "Video uchun poster (720x405)",
                    'options' => [
                        'accept' => 'image/*',
                    ]
                ]*/
            ]
        ]); ?>
    </div>

</div>
<?= \soft\helpers\SHtml::submitButton("Saqlash", ['visible' => !$this->isAjax]) ?>
<?php SActiveForm::end(); ?>
