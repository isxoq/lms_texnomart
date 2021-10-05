<?php

use soft\helpers\SHtml;
use soft\grid\SKGridView;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\models\search\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teams';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'bulkButtons' => false,
        'cols' => [
            'fullname',
            'position',
            'status',
            'image',
            //'socials:ntext',
            'actionColumn',
        ],
    ]); ?>
</div>
