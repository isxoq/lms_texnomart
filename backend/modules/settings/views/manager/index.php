<?php

use backend\modules\settings\models\Settings;
use yii\bootstrap\Modal;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\settings\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Asosiy ma'lumotlar";
$this->params['breadcrumbs'][] = $this->title;

$this->registerAjaxCrudAssets([
    'size' => Modal::SIZE_LARGE,
]);

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
    'bulkButtonsTemplate' => "{delete}",
    'cols' => [

        'checkboxColumn',
        'description',
        [
            'attribute' => 'section',
            'width' => '100px',
            'filter' => map(\backend\modules\settings\models\Settings::getAll(), 'section', 'section'),
        ],
        'key',
        [

            'attribute' => 'value',
            'value' => function ($model) {
                return $model->formattedValue;
            },
            'format' => 'raw',
            'width' => '300px',
        ],
        'actionColumn' => [

            'template' => "{view}{edit}{delete}",
               'buttons' => [

                   'edit' => function($url, $model){
                       /** @var Settings $model */

                        $options = [
                            'class' => 'dropdown-item',
                            'title' => "Tahrirlash",
                            'data-pjax' => 0,
                            'data-toggle' => 'tooltip'
                        ];

                        if ($model->type != Settings::TYPE_TEXT_EDITOR){
                            $options['role'] = 'modal-remote';
                         }

                        return a("Tahrirlash", ['update', 'id' => $model->id], $options, 'edit');

                   }

               ] ,

        ]

    ],
]) ?>

