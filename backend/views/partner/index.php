<?php


/* @var $this backend\components\BackendView */
/* @var $searchModel backend\models\search\PartnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partners';
$this->params['breadcrumbs'][] = $this->title;
?>


<?= \soft\adminty\GridView::widget([
    'dataProvider' => $dataProvider,
    'cols' => [
        'image',
        'link',
        'status',
        'actionColumn',
    ],
]); ?>
