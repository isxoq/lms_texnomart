<?php

use backend\modules\kursmanager\models\Enroll;
use yii\widgets\Pjax;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Kurs */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var backend\modules\kursmanager\models\search\EnrollSearch $searchModel */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "A'zo bo'lganlar";


?>

<?php Pjax::begin(['id' => 'kurs-view-pjax']) ?>

<?=  $this->render('_kursMenu', ['model' => $model]); ?>

<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel' => [
        'heading' => $model->title,
    ],
    'bulkButtons' => false,
    'toolbarTemplate' => "{refresh}",
    'cols' => [
        [
            'attribute' => 'userFullname',
            'label' => "O'quvchi",
            'format' => 'raw',
            'value' => function($model){
                /** @var Enroll $model */
                return $model->user->fullname;
            }
        ],
        [
          'attribute' => 'sold_price',
          'filter' => false,
          'format' => 'sum',
          'label' => "To'lov",
        ],
        [
            'attribute' => "Ko'rilgan mavzular",
            'value' => function ($model) {
                /** @var Enroll $model */
                $text = $model->getUserLessonsInfo();
                return a($text, ['enroll/lessons-info', 'id' => $model->id, 'per-page' => 50], ['class' => 'text-primary', 'data-pjax' => 0, 'title' => "Batafsil ko'rish uchun bosing"]);
            },
            'format' => 'raw',
            'width' => '200px',
            'filter' => false,

        ],

        'created_at' => [
            'label' => "A'zo bo'lgan sana",
            'filter' => false,
        ],

        'end_at' => [
            'label' => "A'zolikning tugash sanasi",
            'filter' => false,
            'format' => 'dateUz',
        ],
    ],
]); ?>

<?php Pjax::end() ?>