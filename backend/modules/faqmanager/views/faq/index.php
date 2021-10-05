<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this \backend\components\BackendView */
/* @var $searchModel backend\modules\faqmanager\models\FaqCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FAQ  Savollar';
$this->params['breadcrumbs'][] = $this->title;

$this->registerAjaxCrudAssets([
    'size' => 'modal-lg',
]);

?>
<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'bulkButtonsTemplate' => "{delete}",
    'cols' => [
        'checkboxColumn',
        'title_uz',
        'title_ru',
        [
            'attribute' => 'category_id',
            'filter' => map(\backend\modules\faqmanager\models\FaqCategory::getAll(), 'id', 'title'),
            'value' => function($model){
                return $model->category->title ?? null;
            }
        ],
        'status',
        'actionColumn',
    ]
]) ?>
