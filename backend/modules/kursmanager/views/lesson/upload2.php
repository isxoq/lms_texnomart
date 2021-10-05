<?php

use yii\helpers\Url;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */

$this->title = "Video yuklash - " . $model->title;
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['section', 'id' => $model->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->section->title, 'url' => ['section/view', 'id' => $model->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['lesson/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Video yuklash";


$this->registerJsFile('@web/js/fui-media.js', ['depends' => \yii\web\JqueryAsset::class]);

$returnUrl = to(['view', 'id' => $model->id]);
$saveMediaUrl = to(['save-media', 'id' => $model->id]);
?>


<div id="waiting-area" style="display: none">
    <div class="preloader3 loader-block">
        <div class="circ1"></div>
        <div class="circ2"></div>
        <div class="circ3"></div>
        <div class="circ4"></div>
    </div>

    <p class="text-muted h5 text-center">Yuklangan video saqlanmoqda. <br>Bu bir necha daqiqa vaqt olishi mumkin.
    </p>
</div>

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
            'fileuploaded' => "function() { 
//                 window.location.href = '{$returnUrl}'  
            }"
        ]

    ])->label(false) ?>

    <?php SActiveForm::end(); ?>
</div>
