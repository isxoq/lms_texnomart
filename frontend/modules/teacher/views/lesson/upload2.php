<?php

use yii\helpers\Url;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */

$this->title = "Video yuklash - " . $model->title;
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['/teacher/kurs']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['/teacher/section', 'id' => $model->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->section->title, 'url' => ['/teacher/section/view', 'id' => $model->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['/teacher/lesson/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Video yuklash";


$this->registerJsFile('@web/js/fui-media.js', ['depends' => \yii\web\JqueryAsset::class]);

$returnUrl = to(['view', 'id' => $model->id]);
$saveMediaUrl = to(['save-media', 'id' => $model->id]);
?>

<div id="message_area" style="display: none">

</div>

<p>
    <a href="<?= Url::to(['view', 'id' => $model->id]) ?>" class="btn btn-info">
        <i class="fa fa-arrow-left"></i> Ortga qaytish
    </a>
    <a id="success_button" href="<?= Url::current() ?>" class="btn btn-success" style="display: none">
        <i class="fa fa-sync-alt"></i> Qaytadan yuklash
    </a>
</p>


<div id="upload-area">
    <?php $form = SActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <?= $form->field($model, 'src')->widget('\kartik\widgets\FileInput', [
        'options' => [
            'multiple' => false,
            'accept' => 'video/*',
        ],
        'language' => 'uz',
        'pluginOptions' => [
            'uploadUrl' => Url::to(['upload-media', 'id' => $model->id]),
            'maxFileCount' => 1,
            'maxFileSize' => Yii::$app->params['maxVideoSize'],
            'dropZoneTitle' => 'Videoni yuklang',
            'msgPlaceholder' => 'Videoni tanlang',
        ],

        'pluginEvents' => [
            'fileuploaded' => "

                function(e, data) { 
    
    
                    let response = data.response
                    let message = response.message
                    let status = response.status
                    let message_area = $('#message_area')
    
                    if (status === 200){
                        
                        if (response.redirect){
                            window.location.href = response.redirect
                        }
                        else{
                            message_area.addClass('alert')
                            message_area.addClass('alert-success')
                            message_area.html(message)
                            message_area.show()
                            $('#upload-area').hide()
                            $('#success_button').show()
                        }
                        
                    }
                    else{
                        message_area.addClass('alert')
                        message_area.addClass('alert-danger')
                        message_area.html(message)
                        message_area.show()
                    }
                }
",

        ]

    ])->label(false) ?>

    <?php SActiveForm::end(); ?>

</div>
