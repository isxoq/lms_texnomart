<?php

use backend\modules\contactmanager\models\Contact;
use soft\helpers\SHtml;
use soft\grid\SKGridView;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\contactmanager\models\search\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Xabarlar";
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets([
    'size' => \yii\bootstrap4\Modal::SIZE_LARGE,
]);
?>

<?= \soft\adminty\GridView::widget([

    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => "{refresh}",
    'bulkButtonsTemplate' => "{delete}",
    'cols' => [
        'checkboxColumn',
        'firstname',
        'lastname',
        'phone',
        'body',
        'created_at',
        [
            'attribute' => 'status',
            'label' => 'Holat',
            'format' => 'raw',
            'value' => function($model){
                /** @var Contact $model */
                return $model->statusLabel ." ".$model->getMarkAsReadButton();
            }
        ],
        'actionColumn' => [
            'viewOptions' => [
                'role' => 'modal-remote',
            ]
        ],
    ]


]) ?>
