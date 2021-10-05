<?php

use backend\modules\kursmanager\models\Section;
use yii\widgets\Pjax;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Kurs */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var frontend\modules\teacher\models\search\SectionSearch $searchModel */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['kurs/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Bo'limlar";

?>


<?php Pjax::begin(['id' => 'kurs-view-pjax']) ?>

<?php $this->registerAjaxCrudAssets(); ?>

<?= $this->render('_kursMenu', ['model' => $model]); ?>

<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel' => [
        'heading' => $model->title,
        'before' => "<b>{$model->title}</b> - Bo'limlar ro'yxati",
    ],
    'bulkButtons' => false,
    'toolbarTemplate' => "{create}{edit-all}{refresh}",
    'toolbarButtons' => [
        'create' => [
            'modal' => true,
            'url' => to(['section/create', 'id' => $model->id])
        ],
        'edit-all' => [
            'label' => "Bo'limlarni boshqarish",
            'pjax' => false,
            'url' => to(['edit-sections', 'id' => $model->id]),
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
            'value' => function($model){
                /** @var Section $model */
                return a($model->title, ['section/view', 'id' => $model->id], ['data-pjax' => 0]);
            }
        ],
        [
            'width' => '200px',
            'format' => 'raw',
            'label' => "Mavzular",
            'value' => function ($model) {

                /** @var Section $model */

                return "<small class='text-muted'>
                            <a href='" . to(['section/lessons', 'id' => $model->id]) . "'  data-pjax='0'  class='text-info'><b>Jami mavzu: </b> {$model->lessonsCount}</a>
                            <br>
                            <b>Faol: </b> {$model->activeLessonsCount}
                            <br>
                        </small>";

            }
        ],

        [
            'width' => '200px',
            'format' => 'raw',
            'label' => "Videolar",
            'value' => function ($model) {

                /** @var Section $model */

                return "<small class='text-muted'>
                            <b>Videolar: </b> {$model->videosCount} <br>
                            <b>Davomiyligi: </b> {$model->formattedVideosDuration}
                        </small>";

            }
        ],
        'status',
        'actionColumn' => [

            'template' => "{view}{lessons}{update}{delete}",
            'controller' => 'section',
            'updateOptions' => [
                'role' => 'modal-remote',
            ],
            'buttons' => [
                'lessons' => function ($url) {
                    return a(fa('list') . " Mavzularga o'tish", $url, ['class' => 'dropdown-item', 'data-pjax' => 0]);
                }
            ]
        ],
    ],
]); ?>

<?php Pjax::end() ?>
