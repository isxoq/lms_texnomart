<?php


/* @var $this backend\components\BackendView */
/* @var $searchModel backend\models\search\TestimonialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mijozlar fikri';
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'cols' => [
            'user.fullname',
            'title_uz',
            'title_ru',
            'text_uz',
            'text_ru',
            'status',
            'actionColumn',
        ],
    ]); ?>
