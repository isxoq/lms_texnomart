<?php

use backend\modules\kursmanager\models\Lesson;
use yii\widgets\Pjax;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Section */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var frontend\modules\teacher\models\search\LessonSearch $searchModel */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['kurs/view', 'id' => $model->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => "Bo'limlar", 'url' => ['kurs/sections', 'id' => $model->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['section/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Mavzular";

Pjax::begin(['id' => 'section-lessons-pjax']);

$this->registerAjaxCrudAssets();
echo $this->render('_sectionMenu', ['model' => $model]);

?>

<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel' => [
        'heading' => $model->title,
        'before' => "Mazular ro'yxati",
    ],
    'bulkButtons' => false,
    'toolbarTemplate' => "{create} {edit-all} {refresh}",
    'toolbarButtons' => [
        'create' => [
            'label' => "Yangi mavzu",
            'url' => to(['lesson/create', 'id' => $model->id]),
            'modal' => true,
        ],
        'edit-all' => [
            'label' => "Mavzularni boshqarish",
            'pjax' => false,
            'url' => to(['edit-lessons', 'id' => $model->id]),
            'icon' => 'edit',
            'title' => "Barchasini tahrirlash",
            'style' => '',
            'outline' => \soft\widget\SButton::OUTLINE['info'],
        ],
    ],
    'cols' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($model) {
                return a($model->title, ['lesson/view', 'id' => $model->id], ['data-pjax' => 0]);
            }

        ],
        [
            'attribute' => 'type',
            'value' => function($model){
                /** @var Lesson $model */
                return $model->typeLabel;
            },
            'filter' => Lesson::getTypesList(),
        ],
        [
            'format' => 'raw',
            'label' => " ",
            'width' => '200px',
            'value' => function($model){
                /** @var Lesson $model */
                if ($model->isTaskLesson){
                    return "";
                }
                return $model->streamStatusLabel;
            }
        ],
        [
            'format' => 'raw',
            'label' => "Fayllar",
            'value' => function ($model) {

                return a("Fayllar <label class='badge badge-inverse-primary'>{$model->getFiles()->count()}</label>",
                    ['lesson/files', 'id' => $model->id], ['data-pjax' => 0, 'class' => 'text-primary']);

            }
        ],
        'status',
        'actionColumn' => [
            'controller' => 'lesson',
            'updateOptions' => ['role' => 'modal-remote'],
        ],
    ],
]); ?>

<?php Pjax::end() ?>