<?php

use soft\kartik\SActiveForm;
use soft\form\SForm;
use backend\modules\kursmanager\models\Lesson;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */
/* @var $form soft\kartik\SActiveForm */
$isTypeChangeable = $model->isTypeChangeable;
?>


<?php $form = SActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>


<?= $form->errorSummary($model) ?>
    <div class="row">
        <div class="col-md-12">
            <?= SForm::widget([
                'model' => $model,
                'form' => $form,
                'attributes' => [
                    'title',
                    'type:dropdownList' => [
                        'items' => Lesson::getTypesList(),
                        'options' => [
                            'id' => 'lesson-type-input'
                        ]
                    ],
                    'media_stream_src' => [
                        'visible' => $isTypeChangeable,
                        'label' => false,
                        'options' => [
                            'id' => 'media-src-input',
                            'placeholder' => 'https://www.youtube.com/watch?virtualdars',
                            'style' => ['display' => $model->isYoutubeLink ? 'block' : 'none']
                        ]
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
<?php

if ($isTypeChangeable) {
    $js = <<<JS

    $(document).on('change', '#lesson-type-input', function(e){
        
        
        let val = $(this).val()
        let media_src_input = $('#media-src-input')
        if (val == 'youtube'){
            media_src_input.show()
        }
        else{
            media_src_input.hide()
        }
        
    })
    

JS;
    $this->registerJs($js);
}


?>