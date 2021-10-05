<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\billing\models\OfflinePayments;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\billing\models\search\OfflinePaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = "Offline to'lovlar";
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="text-primary h4">
    Jami to'lov miqdori:
    <b><?=  OfflinePayments::formattedTotalamount() ?></b>
</p>

<?= \soft\adminty\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showPageSummary' => true,
    'cols' => [
        [
            'label' => "Talaba",
            'width' => '100px',
            'attribute' => 'user.firstname',
        ],
        'course.title',
        'created_at',
        [
            'attribute' => 'amount',
            'pageSummary' => true,
            'format' => 'sum',
        ],
        [
            'attribute' => 'type',
            'format' => 'raw',
            'filter' => map(\backend\modules\billing\models\PaymentTypes::find()->all(), 'type', 'name'),
            'value' => function ($model) {
                /** @var backend\modules\billing\models\OfflinePayments $model */
                return $model->paymentType->name;
            }
        ],
        'actionColumn'
    ],
]); ?>

