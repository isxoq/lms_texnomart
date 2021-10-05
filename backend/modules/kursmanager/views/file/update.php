<?php

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\File */
/* @var $lesson frontend\modules\teacher\models\Lesson */
/* @var $upload soft\helpers\UploadHelper */

$this->title = "Tahrirlash";
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->kurs->title, 'url' => ['section', 'id' => $model->lesson->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->section->title, 'url' => ['section/view', 'id' => $model->lesson->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->title, 'url' => ['lesson/view', 'id' => $model->lesson->id]];
$this->params['breadcrumbs'][] = ['label' => "Fayllar", 'url' => ['lesson/files', 'id' => $model->lesson->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['file/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>



<?= $this->render('_form', [
    'model' => $model,
    'lesson' => $lesson,
    'upload' => $upload,
]); ?>