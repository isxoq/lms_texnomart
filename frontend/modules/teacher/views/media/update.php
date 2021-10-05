<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this yii\web\View */
/* @var $model frontend\modules\teacher\models\Media */
/* @var $lesson frontend\modules\teacher\models\Lesson */

$this->title = "Tahrirlash";
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['/teacher/kurs']];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->kurs->title, 'url' => ['/teacher/section', 'id' => $model->lesson->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->section->title, 'url' => ['/teacher/section/view', 'id' => $model->lesson->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->title, 'url' => ['/teacher/lesson/view', 'id' => $model->lesson->id]];
$this->params['breadcrumbs'][] = ['label' => "Videolar", 'url' => ['/teacher/lesson/all-media', 'id' => $model->lesson->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

$lessons = $lesson->section->getLessons()->nonDeleted()->all();

?>


<?= $this->render('_form', [
    'model' => $model,
    'lesson'  => $lesson,
]) ?>