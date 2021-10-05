<?php

/* @var $this \yii\web\View */
/* @var $model frontend\modules\teacher\models\Media */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['/teacher/kurs']];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->kurs->title, 'url' => ['/teacher/section', 'id' => $model->lesson->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->section->title, 'url' => ['/teacher/section/view', 'id' => $model->lesson->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->title, 'url' => ['/teacher/lesson/view', 'id' => $model->lesson->id]];
$this->params['breadcrumbs'][] = ['label' => "Videolar", 'url' => ['/teacher/lesson/all-media', 'id' => $model->lesson->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\adminty\DetailView::widget([

    'model' => $model,
    'panel' => [
        'type' => \soft\bs4\Card::TYPE_SUCCESS
//        'header' => false,
    ],
    'attributes' => [
        'title',
        'description:text',
        [
            'attribute' => 'org_name',
            'visible' => $model->hasStreamedMedia,
        ],
        [
            'attribute' => 'duration',
            'format' => 'gmtime',
            'visible' => $model->hasStreamedMedia,
        ],
        [
            'format' => 'raw',
            'label' => "Video",
            'value' => function ($model) {
                if ($model->hasStreamedMedia) {
                    return $this->render('_videoPlayer', ['model' => $model]);
                } else {
                    return a("<i data-feather='upload'></i> Video yuklash", ['upload', 'id' => $model->id], ['class' => 'btn btn-info']);
                }

            }
        ]

    ]

]) ?>


