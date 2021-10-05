<?php

use yii\helpers\Html;
use soft\adminty\GridView;
use backend\modules\kursmanager\models\KursComment;
use backend\modules\kursmanager\models\Kurs;

/* @var $this \soft\web\SView */
/* @var $searchModel backend\modules\kursmanager\models\search\KursCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kurs Comments';
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();

?>

<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'bulkButtonsTemplate' => '{delete}{activate}{inactivate}',
    'bulkButtons' => [
        'activate' => [
            'confirmMessage' => "Siz rostdan ham tanlangan  fikrlarni faol holatga o'tkazmoqchimisiz?",
            'label' => 'Faollashtirish',
            'url' => to(['bulk-change-status', 'status' => 1]),
            'icon' => 'check,fas',
            'style' => 'btn-success',
            'title' => 'Tanlangan fikrlarni faollashtirish',
            'options' => [
                'class' => 'ml-1'
            ]
        ],

        'inactivate' => [
            'confirmMessage' => "Siz rostdan ham tanlangan  fikrlarni nofaol holatga o'tkazmoqchimisiz?",
            'label' => 'Nofaollashtirish',
            'url' => to(['bulk-change-status', 'status' => 0]),
            'icon' => 'times,fas',
            'style' => 'btn-warning',
            'title' => 'Tanlangan fikrlarni nofaollashtirish',
            'options' => [
                'class' => 'ml-1'
            ]
        ],
    ],
    'cols' => [
        'checkboxColumn',
        [
            'attribute' => 'text',
            'format' => 'raw',
            'value' => function($model){
                /** @var KursComment $model */
                return a($model->text, ['view', 'id' => $model->id], ['data-pjax' => 0, 'class' => 'text-primary']);
            },
            'width' => '25%',

        ],
        [
            'attribute' => 'user.fullname',
            'width' => '15%',
            'format' => 'small',

        ],
        [
            'label' => "Foyd.<br>bahosi",
            'encodeLabel' => false,
            'attribute' => 'userRating',
            'width' => '5%'
        ],

        [
            'attribute' => 'kurs_id',
            'value' => function ($model) {
                /** @var KursComment $model */
                return $model->kurs->title;
            },
            'filter' => map(Kurs::getAll(), 'id', 'title', 'category.title'),
            'width' => '20%',
            'format' => 'small',
        ],


        [
            'label' => "Javob.<br>soni",
            'encodeLabel' => false,
            'attribute' => 'repliesCount',
            'width' => '5%'
        ],
        [

            'attribute' => 'created_at',
            'format' => 'datetime',
            'width' => '12%'
        ],

        [

            'label' => 'Status',
            'attribute' => 'status',
            'format' => 'status',
            'width' => '10%',
            'filter' => KursComment::statuses()
        ],

        'show_on_slider:bool',

        'actionColumn' => [

            'updateOptions' => [
                'role' => 'modal-remote'
            ],

            'template' => '{view}{update}{approve}{activate}{inactivate}{reply}{delete}',
            'buttons' => [
                'approve' => function ($url, $model) {

                    /** @var KursComment $model */
                    if ($model->status == 5) {
                        return a('<i class="fa fa-check"></i> Tasdiqlash', ['change-status', 'id' => $model->id, 'status' => 1], [
                            'title' => 'Fikrni tasdiqlash',
                            'data-toggle' => 'tooltip',
                            'data-pjax' => 0,
                            'class' => 'dropdown-item',
                            'role' => 'modal-remote',
                            'data-confirm' => false,
                            'data-method' => false,
                            'data-request-method' => 'post',
                            'data-confirm-title' => 'Tasdiqlaysizmi?',
                            'data-confirm-message' => 'Siz rostdan ham ushbu fikrni tasdiqlaysizmi?',
                        ]);
                    }

                },
                'activate' => function ($url, $model) {

                    /** @var KursComment $model */
                    if ($model->status == 0) {
                        return a('<i class="fas fa-check"></i> Faollashtirish', ['change-status', 'id' => $model->id, 'status' => 1], [
                            'title' => 'Faollashtirish',
                            'data-toggle' => 'tooltip',
                            'data-pjax' => 0,
                            'class' => 'dropdown-item',
                            'role' => 'modal-remote',
                            'data-confirm' => false,
                            'data-method' => false,
                            'data-request-method' => 'post',
                            'data-confirm-title' => 'Tasdiqlaysizmi?',
                            'data-confirm-message' => 'Siz rostdan ham ushbu fikrni faol holatga o\'tkazmoqchimisiz?',
                        ]);
                    }

                },
                'inactivate' => function ($url, $model) {

                    /** @var KursComment $model */
                    if ($model->status != 0) {
                        return a('<i class="fas fa-times"></i> Nofaollashtirish', ['change-status', 'id' => $model->id, 'status' => 0], [
                            'title' => 'Nofaollashtirish',
                            'data-toggle' => 'tooltip',
                            'data-pjax' => 0,
                            'class' => 'dropdown-item',
                            'role' => 'modal-remote',
                            'data-confirm' => false,
                            'data-method' => false,
                            'data-request-method' => 'post',
                            'data-confirm-title' => 'Tasdiqlaysizmi?',
                            'data-confirm-message' => 'Siz rostdan ham ushbu fikrni nofaol holatga o\'tkazmoqchimisiz?',
                        ]);
                    }

                },
                'reply' => function ($url, $model) {

                    return a('Javob yozish', $url, ['class' => 'dropdown-item', 'role' => 'modal-remote'], 'reply,fas');
                }
            ]
        ]
    ],
]); ?>
