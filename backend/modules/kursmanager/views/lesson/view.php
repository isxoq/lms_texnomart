<?php


/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Lesson */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['kurs/sections', 'id' => $model->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->section->title, 'url' => ['section/lessons', 'id' => $model->section_id]];
$this->params['breadcrumbs'][] = $this->title;

\yii\widgets\Pjax::begin(['id' => 'lesson-view-pjax']);

echo $this->render('_lessonMenu', ['model' => $model]);
$attributes = [
    'title',
    'status',
    'is_open:bool:Oldindan ko`rishga ruxsat',
    'created_at',
    'updated_at',

];

if ($model->isStreamFinished) {
    $attributes = array_merge($attributes, [
        'media_duration:gmtime',
        'media_size:fileSize',
        [
            'label' => "Video",
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
?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'toolbar' => [
        'buttons' => [
            'update' => ['pjax' => false]
        ]
    ],
    'options' => ['class' => 'table'],
    'attributes' => $attributes
]) ?>

<?php \yii\widgets\Pjax::end() ?>