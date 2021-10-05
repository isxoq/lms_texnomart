<?php


/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */
/* @var $section frontend\modules\teacher\models\Section */

$this->title = "Tahrirlash";

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $section->kurs->title, 'url' => ['kurs/sections', 'id' => $section->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => $section->title, 'url' => ['section/lessons', 'id' => $section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', ['model' => $model]);

?>
