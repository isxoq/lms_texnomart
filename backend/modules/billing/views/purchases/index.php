<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\billing\models\Purchases;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\billing\models\search\PurchasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Sotib olishlar";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchases-index">


    <div class="row">
        <!-- task, page, download counter  start -->
        <div class="col-xl-6 col-md-6">
            <?= \soft\adminty\widgets\ECard::widget([
                'mainLabel' => Yii::$app->formatter->asSum(Purchases::totalRevenue($isPlatform = false)),
                'subLabel' => t("All teachers Revenue"),
                'footerLink' => "",
                'rightIconClass' => 'feather icon-edit f-28'
            ]) ?>
        </div>
        <?php if (Yii::$app->user->can('admin')): ?>
            <div class="col-xl-6 col-md-6">
                <?= \soft\adminty\widgets\ECard::widget([
                    'mainLabel' => Yii::$app->formatter->asSum(Purchases::totalRevenue($isPlatform = true)),
                    'subLabel' => t("All platform Revenue"),
//                'rightIconClass' => 'teacher'
                    'mainLabelClass' => 'text-c-green f-w-600',
                    'bgFooter' => 'bg-c-green',
                    'footerLink' => ''
                ]) ?>
            </div>
        <?php endif ?>

        <!-- task, page, download counter  end -->

    </div>

    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbarTemplate' => "{refresh}",
        'showPageSummary' => true,
        'cols' => [
            [
                'attribute' => 'userFullName',
                'format' => 'raw',
                'width' => '140px',
                'label' => "FIO",
                'value' => function ($model) {
                    /** @var Purchases $model */
                    if ($model->user == null){
                        return '';
                    }
                    return $model->user->firstname . "<br>" . $model->user->lastname;
                }

            ],
            [
                'attribute' => 'courseTitle',
                'format' => 'raw',
                'label' => "Kurs",
                'width' => '200px',
                'value' => function ($model) {
                    /** @var Purchases $model */
                    return $model->course->title;
                }

            ],
            [
                'attribute' => 'amount',
                'format' => 'integer',
                'pageSummary' => true,
                'width' => '100px',
            ],
            [
                'attribute' => 'teacher_fee',
                'format' => 'integer',
                'pageSummary' => true,
                'width' => '70px',
            ],
            [
                'attribute' => 'platform_fee',
                'format' => 'integer',
                'pageSummary' => true,
                'width' => '70px',
            ],
            'payment_type',
            [
                'attribute' => 'transaction_id',
                'width' => '20px',

            ],
            'actionColumn'
//            'status',

        ],
    ]); ?>


</div>
