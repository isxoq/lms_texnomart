<?php

use soft\bs4\dosamigosfileupload\FileUploadUI;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */

$this->title = "Video yuklash";
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['section', 'id' => $model->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->section->title, 'url' => ['section/view', 'id' => $model->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['lesson/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Video yuklash";


$this->registerJsFile('@web/js/fui-media.js', ['depends' => \yii\web\JqueryAsset::class]);

$returnUrl = to(['view', 'id' => $model->id]);


?>
<?= FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'src',
    'url' => ['lesson/upload-media', 'id' => $model->id],
    'gallery' => false,
    'options' => [
        'accept' => 'video/*',
        'multiple' => false,
    ],
    'clientOptions' => [
        'maxFileSize' => 419430400, // 400 mb
        "maxNumberOfFiles" => 1
    ],
    'clientEvents' => [
        'fileuploadadd' => 'function(e, data) {
                          var x = document.getElementById("select-file-button")
                          x.style.display = "none"
                            }',
        'fileuploaddone' => 'function(e, data) {
                                window.location.href = data.result.returnUrl
                                
                            }',
        'fileuploadfail' => 'function(e, data) {
                            var x = document.getElementById("select-file-button")
                            x.style.display = "inline-block"
                            }',

    ],
]); ?>
