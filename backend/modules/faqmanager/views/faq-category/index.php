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

$this->title = 'Faq Categories';
$this->params['breadcrumbs'][] = $this->title;

$this->registerAjaxCrudAssets();

?>
<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,

    'toolbarButtons' => [
        'create' => [
            'modal' => true,
        ]
    ],
    'cols' => [
        'title_uz',
        'title_ru',
        'status',
        'actionColumn' => [
            'template' => "{update}{delete}",
            'updateOptions' => [
                'role' => 'modal-remote'
            ]
        ]
    ]
]) ?>
