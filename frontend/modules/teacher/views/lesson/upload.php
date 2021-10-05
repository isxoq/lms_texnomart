<?php

use soft\bs4\dosamigosfileupload\FileUploadUI;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */

$this->title = "Video yuklash";
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['/teacher/kurs']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['/teacher/section', 'id' => $model->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->section->title, 'url' => ['/teacher/section/view', 'id' => $model->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['/teacher/lesson/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Video yuklash";


$this->registerJsFile('@web/js/fui-media.js', ['depends' => \yii\web\JqueryAsset::class]);

$returnUrl = to(['view', 'id' => $model->id]);


?>
<?= FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'src',
    'url' => ['/teacher/lesson/upload-media', 'id' => $model->id],
    'gallery' => false,
    'options' => [
        'accept' => 'video/*',
        'multiple' => false,
    ],
    'clientOptions' => [
        'maxFileSize' => 2500 * 1024 * 1024,
        "maxNumberOfFiles" => 1
    ],
    'clientEvents' => [
        'fileuploadadd' => <<<JS
                        function(e, data) {
                            var x = document.getElementById("select-file-button")
                            x.style.display = "none"
                        }
JS,

        'fileuploaddone' => <<<JS
                            function(e, data) {
                                window.location.href = data.result.returnUrl
                            }'
JS,
        'fileuploadfail' => 'function(e, data) {
                            var x = document.getElementById("select-file-button")
                            x.style.display = "inline-block"
                            }',

    ],
]); ?>
