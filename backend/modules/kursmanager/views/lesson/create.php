<?php


/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */
/* @var $section frontend\modules\teacher\models\Section */

$this->title = "Yangi mavzu qo'shish";

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['kurs/view', 'id' => $section->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => "Bo'limlar", 'url' => ['kurs/sections', 'id' => $section->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => $section->title, 'url' => ['section/view', 'id' => $section->id]];
$this->params['breadcrumbs'][] = ['label' => "Mavzular", 'url' => ['section/lessons', 'id' => $section->id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<p class="h5 text-muted"> <b class="text-primary"> <?= $section->title ?> </b> bo'limiga yangi mavzu qo'shish</p>

 <?= $this->render('_form', ['model' => $model]); ?>
