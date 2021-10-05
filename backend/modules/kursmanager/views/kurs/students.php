<?php

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

<?= $this->render('_kursMenu', ['model' => $model]); ?>

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
            'value' => function ($model) {
                return $model->user->fullname;
            }
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
        'actionColumn' => [
            'template' => "{delete-enroll}",
            'buttons' => [
                'delete-enroll' => function ($url) {
                    return a("A'zolikni o'chirish", $url, [
                        'class' => 'dropdown-item',
                        'role' => 'modal-remote',
                        'data' => [
                            'confirm' => false,
                            'method' => false,
                            'request-method' => 'post',
                            'confirm-title' => "Tasdiqlaysizmi?",
                            'confirm-message' => "Siz rostdan ham ushbu a'zolikni o'chirishni xoxlaysizmi?",
                        ],
                    ], 'user-times,fas');
                }
            ]
        ]
    ],
]); ?>

<?php Pjax::end() ?>