<?php

use soft\helpers\SHtml;
use soft\grid\SKGridView;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\categorymanager\models\search\SubCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-category-index">

    <h1><?= SHtml::encode($this->title) ?></h1>
    <p>
        <?= SHtml::createButton() ?>    </p>


    <?= SKGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'cols' => [
            'id',
            'image',
            'slug',
            'category_id',
            //'created_at',
            //'updated_at',
            //'status',
            'actionColumn',
        ],
    ]); ?>
</div>
