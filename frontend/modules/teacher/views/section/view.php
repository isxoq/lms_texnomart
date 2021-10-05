<?php

use yii\widgets\Pjax;

/* @var $this backend\components\BackendView */
/* @var $model frontend\modules\teacher\models\Section */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['/teacher/kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['/teacher/kurs/view', 'id' => $model->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => "Bo'limlar", 'url' => ['/teacher/kurs/sections', 'id' => $model->kurs_id]];
$this->params['breadcrumbs'][] = $this->title;


Pjax::begin(['id' => 'section-lessons-pjax']);

echo $this->render('_sectionMenu', ['model' => $model]);
?>

<?= \soft\adminty\DetailView::widget([

    'model' => $model,
    'toolbar' => false,
    'attributes' => [
        'title',
        'kurs.title',
        'created_at',
        'updated_at',
        'status',
    ]

]) ?>

<?php  Pjax::end() ?>