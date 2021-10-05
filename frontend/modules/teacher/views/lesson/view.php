<?php


/* @var $this frontend\components\FrontendView */

/* @var $model frontend\modules\teacher\models\Lesson */

use soft\adminty\DetailView;
use yii\widgets\Pjax;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['/teacher/kurs']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['/teacher/kurs/sections', 'id' => $model->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->section->title, 'url' => ['/teacher/section/lessons', 'id' => $model->section_id]];
$this->params['breadcrumbs'][] = $this->title;

Pjax::begin(['id' => 'lesson-view-pjax']);

echo $this->render('_lessonMenu', ['model' => $model]);
$attributes = [
    'title',
    'status',
    'created_at',

];

if ($model->isYoutubeLink) {

    if ($model->media_stream_src) {
        $attributes = array_merge($attributes, [
            [
                'attribute' => 'media_stream_src',
                'label' => 'Url',
                'format' => 'url',
            ],
            'media_duration:gmtime',
            [
                'label' => 'Video',
                'format' => 'raw',
                'value' => function ($model) {
                    return $this->render('_watchMedia', ['model' => $model]);
                }
            ],
        ]);
    } else {

        $attributes = array_merge($attributes, [
            [
                'attribute' => 'media_stream_src',
                'label' => 'Url',
                'format' => 'url',
            ],

        ]);

    }
}

if ($model->isVideoUploadLesson) {
    if ($model->isStreamFinished) {
        $attributes = array_merge($attributes, [
            'media_duration:gmtime',
            'media_size:fileSize',
            [
                'label' => 'Video',
                'format' => 'raw',
                'value' => function ($model) {
                    return $this->render('_watchMedia', ['model' => $model]);
                }
            ],
        ]);
    } else {
        $attributes = array_merge($attributes, [
            [
                'attribute' => 'streamStatusLabel',
                'format' => 'raw',
            ]
        ]);
    }
}

?>

<?= DetailView::widget([
    'model' => $model,
    'toolbar' => [
        'buttons' => [
            'update' => [
                'pjax' => false
            ]
        ]
    ],
    'options' => ['class' => 'table'],
    'attributes' => $attributes
]) ?>

<?php Pjax::end() ?>