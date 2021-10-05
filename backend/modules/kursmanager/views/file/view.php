<?php



/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\File */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->kurs->title, 'url' => ['section', 'id' => $model->lesson->kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->section->title, 'url' => ['section/view', 'id' => $model->lesson->section->id]];
$this->params['breadcrumbs'][] = ['label' => $model->lesson->title, 'url' => ['lesson/view', 'id' => $model->lesson->id]];
$this->params['breadcrumbs'][] = ['label' => "Fayllar", 'url' => ['lesson/files', 'id' => $model->lesson->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= \soft\adminty\DetailView::widget([

    'model' => $model,
    'attributes' => [
        'title',
        'downloadFileButton:raw',
        'org_name',
        'size:fileSize',
        'extension',
        'description',
        'status',
        'created_at',
        'updated_at',
    ]

]) ?>
