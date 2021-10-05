<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\faqmanager\models\FaqCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faq Categories';
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'cols' => [

            'title',
            'status',
            'actionColumn'

        ],
    ]); ?>
