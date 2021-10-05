<?php

use backend\modules\ordermanager\models\Order;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\ordermanager\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerAjaxCrudAssets();

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => "{refresh}",
    'bulkButtonsTemplate' => "{delete}",
    'cols' => [
        'checkboxColumn',
        'id' => [
            'label' => 'Buyurtma raqami',
            'width' => '70px',
        ],
        'user.fullname',
        'kurs.title',
        'amount:sum',
        'created_at',
        [
            'attribute' => 'status',
            'label' => "To'lov qilingan",
            'format' => 'raw',
            'value' => function ($model) {
                /** @var Order $model */
                return Yii::$app->formatter->asBool($model->isPayed);
            },
            'filter' => [
                Order::STATUS_PAYED => "Ha",
                Order::STATUS_NOT_PAYED => "Yo'q",
            ]
        ],
        'actionColumn' => [
            'template' => "{delete}",
            'deleteOptions' => [
                'role' => 'modal-remote'
            ]
        ],
    ],
]); ?>
