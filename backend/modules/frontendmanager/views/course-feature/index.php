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

$this->title = 'Kurs help blok';
$this->description = "Ushbu ma'lumotlar 'Kurslar' sahifasida kurslar ro'yxatidan keyin pastda chiqadi";
$this->params['breadcrumbs'][] = $this->title;

$this->registerAjaxCrudAssets();

?>
<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,

    'toolbarButtons' => [
        'create' => [
            'modal' => true,
        ]
    ],
    'cols' => [
        'title_uz',
        'text_uz',
        'title_ru',
        'text_ru',
        'status',
        'actionColumn' => [
//            'template' => "{update}{delete}",
            'updateOptions' => [
                'role' => 'modal-remote'
            ],
            'viewOptions' => [
                'role' => 'modal-remote'
            ],
        ]
    ]
]) ?>
