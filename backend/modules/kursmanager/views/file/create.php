<?php

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\File */
/* @var $lesson frontend\modules\teacher\models\Lesson */
/* @var $upload soft\helpers\UploadHelper */

$this->title =  "Yangi fayl qo'shish";
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $lesson->kurs->title, 'url' => ['kurs/view', 'id' => $lesson->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $lesson->section->title, 'url' => ['section/view', 'id' => $lesson->section->id]];
$this->params['breadcrumbs'][] = ['label' => $lesson->title, 'url' => ['lesson/view', 'id' => $lesson->id]];
$this->params['breadcrumbs'][] = ['label' => "Fayllar", 'url' => ['lesson/files', 'id' => $lesson->id]];
$this->params['breadcrumbs'][] = $this->title;

?>


<?= $this->render('_form', [
    'model' => $model,
    'lesson' => $lesson,
    'upload' => $upload,
]); ?>