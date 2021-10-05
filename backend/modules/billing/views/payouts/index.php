<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\billing\models\search\PayoutsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Payouts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payouts-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'cols' => [

            'id',
            'document_file',
            'teacher_id',
            'payment_type',
            'payout_time:datetime',
            'amount',
            'description',
            'status',
            'cancelled_time:datetime',
            'actionColumn'
        ],
    ]); ?>

    <?php Pjax::end(); ?>


</div>
