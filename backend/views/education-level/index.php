<?php


/* @var $this backend\components\BackendView */
/* @var $searchModel backend\models\search\EducationLevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Education Levels';
$this->params['breadcrumbs'][] = $this->title;
?>



<?= \soft\adminty\GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
    'pjax' => true,
    'cols' => [
        'name_uz',
        'name_ru',
        'status',
        'actionColumn',
    ],
]); ?>
