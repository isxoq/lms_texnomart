<?php

use soft\adminty\GridView;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['/teacher/kurs']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['/teacher/kurs/sections', 'id' => $model->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->section->title, 'url' => ['/teacher/section/lessons', 'id' => $model->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['/teacher/lesson/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Fayllar";

\yii\widgets\Pjax::begin(['id' => 'lesson-view-pjax']);

echo $this->render('_lessonMenu', ['model' => $model]);
$this->registerAjaxCrudAssets();
?>

<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'bulkButtons' => false,
    'responsive' => false,
    'toolbarButtons' => [
        'create' => [
            'url' => to(['/teacher/file/create', 'id' => $model->id]),
        ]
    ],
    'panel' => [
        'heading' => false,
        'before' => "Yuklab olish uchun fayllar",
    ],
    'cols' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($model) {
                return a($model->title, ['file/view', 'id' => $model->id], ['data-pjax' => 0, 'class' => 'text-primary']);
            }
        ],
        'size:fileSize',
        'extension',
        'downloadFileButton:raw',
        'status',
        'actionColumn' => [
            'controller' => 'file',
            'width' => '250px',
        ]
    ]
])

?>

<?php \yii\widgets\Pjax::end() ?>