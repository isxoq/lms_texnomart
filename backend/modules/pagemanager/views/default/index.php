<?php


/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\pagemanager\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = $this->title;

?>
    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
        'cols' => [
            'title',
            'idn',
            'status',
            'updated_at',
            'actionColumn',
        ]
    ]); ?>

