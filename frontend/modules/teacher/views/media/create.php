<?php

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Media */
/* @var $lesson frontend\modules\teacher\models\Lesson */

$this->title =  "Yangi video qo'shish";
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['/teacher/kurs']];
$this->params['breadcrumbs'][] = ['label' => $lesson->kurs->title, 'url' => ['/teacher/section', 'id' => $lesson->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $lesson->section->title, 'url' => ['/teacher/section/view', 'id' => $lesson->section->id]];
$this->params['breadcrumbs'][] = ['label' => $lesson->title, 'url' => ['/teacher/lesson/view', 'id' => $lesson->id]];
$this->params['breadcrumbs'][] = "Yangi video qo'shish";

?>

<?= $this->render('_form', [
    'model' => $model,
    'lesson'  => $lesson,
]) ?>