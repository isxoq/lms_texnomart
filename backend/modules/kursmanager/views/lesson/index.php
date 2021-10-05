<?php

use soft\helpers\SUrl;

/* @var $this \frontend\components\FrontendView */
/* @var $searchModel frontend\modules\teacher\models\search\SectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $kurs \frontend\modules\teacher\models\Kurs */

$this->title = $kurs->title . " - Bo'limlar ro'yxati";
$this->params['breadcrumbs'][] = ['label' => "Kurs boshqaruvchisi", 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $kurs->title, 'url' => ['kurs/view', 'id' => $kurs->id]];
$this->params['breadcrumbs'][] = "Bo'limlar ro'yxati";
$this->registerAjaxCrudAssets();
?>
<div class="section-index">

    <?= \soft\adminty\GridView::widget([
        'id' => 'crud-datatable',
        'dataProvider' => $dataProvider,
        'panel' => [
            'heading' => $kurs->title,
            'before' => "Bo'limlar ro'yxati",
        ],
        'filterModel' => $searchModel,
        'bulkButtons' => false,
        'toolbarTemplate' => "{create} {edit-all} {refresh}",
        'toolbarButtons' => [
            'create' => [
                'modal' => true,
                'url' => to(['create', 'id' => $kurs->id])
            ],
            'edit-all' => [
                'modal' => true,
                'pjax' => false,
                'url' => SUrl::to(['edit-all', 'id' => $kurs->id]),
                'icon' => 'edit',
                'options' => [
                    'class' => 'btn-outline-warning',
                ],
                'title' => "Barchasini tahrirlash",
            ],
        ],
        'cols' => [
            [
                'class' => \soft\grid\SExpandRowColumn::class,
                'attribute' => 'title',
                'detail' => function ($model) {
                    $dataProvider = new \yii\data\ActiveDataProvider([
                        'query' => $model->getLessons()
                    ]);
                    return $this->render('_lessons', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                    ]);
                }
            ],
            'title',
            'created_at',
            'status',
            'actionColumn' => [
                'updateOptions' => [
                    'role' => 'modal-remote',
                ]
            ],
        ],
    ]); ?>
</div>
