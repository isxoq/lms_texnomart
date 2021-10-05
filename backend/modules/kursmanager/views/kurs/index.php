<?php

use backend\modules\categorymanager\models\SubCategory;
use backend\modules\kursmanager\models\Kurs;
use soft\adminty\GridView;
use yii\helpers\ArrayHelper;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\kursmanager\models\search\KursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kurs boshqaruvchisi';
$this->params['breadcrumbs'][] = $this->title;

$categoryMap = ArrayHelper::map(SubCategory::find()->with('category')->all(), 'id', 'title', 'category.title');

$this->registerAjaxCrudAssets();

?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'bulkButtons' => false,
    'responsive' => true,
    'toolbarButtons' => [
        'create' => [
            'label' => "Yangi kurs qo'shish",
        ]
    ],
    'pjax' => true,
    'cols' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'width' => '160px',
            'value' => function ($model) {
                return a($model->title, ['view', 'id' => $model->id], ['data-pjax' => 0]);
            }

        ],
        [

            'attribute' => 'category_id',
            'value' => function ($model) {
                /** @var Kurs $model */
                return tag('small', $model->subCategory->category->title . '/<br>' . $model->subCategory->title);
            },
            'width' => '120px',
            'format' => 'raw',
            'filterInputOptions' => ['class' => 'form-control', 'prompt' => 'Barchasi'],
            'filter' => $categoryMap,

        ],
        [
            'format' => 'raw',
            'label' => "Ma'lumot",
            'width' => '150px',
            'encodeLabel' => false,
            'value' => function ($model) {

                /** @var $model Kurs */

                return "<small class='text-muted'>
                            <a href='" . to(['sections', 'id' => $model->id]) . "' data-pjax='0'>
                                                        <b>Jami bo'lim: </b> {$model->sectionsCount};
                                                        <br>
                                                        (<b>Faol: </b> {$model->activeSectionsCount})
                                                        </a>
                            <br>
                            
                            <b>Jami mavzu: </b> {$model->lessonsCount};
                            (<b>Faol: </b> {$model->activeLessonsCount })
                            <br>
                             <a href='" . to(['students', 'id' => $model->id]) . "' data-pjax='0'>
                            <b>A'zo bo'lganlar: </b> {$model->enrollsCount}
                            </a>
                        </small>";

            }
        ],

        [
            'format' => 'raw',
            'label' => 'Videolar',
            'encodeLabel' => false,
            'value' => function ($model) {

                /** @var Kurs $model */

                return "<small class='text-muted'>
                            <b>Videolar: </b> {$model->videosCount} <br>
                            <b>Davomiyligi: </b> {$model->formattedVideosDuration}
                        </small>";

            }
        ],

        [

            'label' => "O'qituvchi",
            'attribute' => 'username',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var Kurs $model */
                return $model->user->fullname;
            }
        ],

        [

            'label' => 'Status',
            'attribute' => 'status',
            'value' => function ($model) {
                /** @var Kurs $model */
                return $model->statusLabel;
            },
            'format' => 'raw',
            'filter' => Kurs::statuses()
        ],

        [
            'attribute' => 'created_at',
            'format' => 'dateUz',
            'width' => '110px',

        ],

        'actionColumn' => [
            'width' => '150px',
            'template' => '{view}{update}{sections}{students}{approve-or-disapprove}{change-status}{delete}',
            'buttons' => [
                'sections' => function ($url, $model) {
                    return a("Bo'limlarni boshqarish", $url, ['class' => 'dropdown-item', 'data-pjax' => 0], 'list');
                },
                'students' => function ($url, $model) {
                    return a("A'zolar", $url, ['class' => 'dropdown-item', 'data-pjax' => 0], 'users');
                },
                'change-status' => function ($url, $model) {

                    /** @var frontend\modules\teacher\models\Kurs $model */
                    if (!$model->isConfirmed) {
                        return '';
                    } else {

                        if ($model->status == 1) {

                            return a('Nofaollashtirish', $url, [

                                'role' => 'modal-remote',
                                'class' => 'dropdown-item',
                                'title' => 'Nofaollashtirish',
                                'data' => [
                                    'pjax' => 0,
                                    'request-method' => 'post',
                                    'toggle' => 'tooltip',
                                    'confirm-title' => 'Tasdiqlaysizmi?',
                                    'confirm-message' => "Siz rostdan ham ushbu kursni nofaol holatga o'tkazmoqchimisiz?",

                                ],


                            ], 'times,fas');

                        } else {

                            return a('Faollashtirish', $url, [

                                'role' => 'modal-remote',
                                'class' => 'dropdown-item',
                                'title' => 'Faollashtirish',
                                'data' => [
                                    'request-method' => 'post',
                                    'pjax' => 0,
                                    'toggle' => 'tooltip',
                                    'confirm-title' => 'Tasdiqlaysizmi?',
                                    'confirm-message' => "Siz rostdan ham ushbu kursni faol holatga o'tkazmoqchimisiz?",

                                ],


                            ], 'check,fas');

                        }

                    }

                },
                'approve-or-disapprove' => function ($url, $model) {

                    /** @var Kurs $model */
                    if ($model->isWaiting) {
                        return a('<i class="fa fa-check"></i> Tasdiqlash', $url, [
                            'title' => 'Kursni tasdiqlash',
                            'data-toggle' => 'tooltip',
                            'data-pjax' => 0,
                            'class' => 'dropdown-item',
                            'role' => 'modal-remote',
                            'data-confirm' => false,
                            'data-method' => false,
                            'data-request-method' => 'post',
                            'data-confirm-title' => 'Tasdiqlaysizmi?',
                            'data-confirm-message' => 'Siz rostdan ham ushbu kursni tasdiqlaysizmi?',
                        ]);
                    } else {
                        return a("Kutish rejimiga o'tkazish", $url, [

                            'role' => 'modal-remote',
                            'class' => 'dropdown-item',
                            'title' => "Kutish rejimiga o'tkazish",
                            'data' => [
                                'pjax' => 0,
                                'request-method' => 'post',
                                'toggle' => 'tooltip',
                                'confirm-title' => 'Tasdiqlaysizmi?',
                                'confirm-message' => "Siz rostdan ham ushbu kursni kutish  holatga o'tkazmoqchimisiz?",

                            ],

                        ], 'hourglass-half,fas');

                    }

                },
            ]
        ],
    ],
]); ?>
