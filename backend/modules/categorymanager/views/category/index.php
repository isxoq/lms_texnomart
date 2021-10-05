<?php

use soft\helpers\SHtml;
use soft\grid\SKGridView;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\categorymanager\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index">
    <?= \soft\adminty\GridView::widget([
        'id' => 'crud-datatable',
        'dataProvider' => $dataProvider,
        'panelTemplate' => '{panelBefore}{items}',
        'panel' => [
            'before' => $this->title,
        ],
        'condensed' => true,
        'cols' => [
            'checkboxColumn',
            [
                'class' => \soft\grid\SExpandRowColumn::class,
                'attribute' => 'title',
                'detail' => function ($model) {
                    $dataProvider = new \yii\data\ActiveDataProvider([
                        'query' => $model->getSubCategories()
                    ]);
                    return $this->render('_subCategories', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                    ]);
                }
            ],
            [
                'attribute' => 'image',
                'format' => 'thumbnail',
                'width' => '100px',
            ],
            [
                'contentOptions' => [
                    'style' => 'overflow: hidden; text-overflow: ellipsis; white-space: break-spaces;word-wrap:anywhere'
                ],
                'attribute' => 'title',
                'format' => 'raw',
            ],
            'status' => [
                'width' => '50px',
            ],
            'actionColumn' => [
                'template' => "{update} {delete}"
            ],
        ],
    ]); ?>
</div>
