<?php

use soft\adminty\GridView;
use soft\helpers\SHtml;

/* @var $this frontend\components\FrontendView */
/* @var $searchModel frontend\modules\teacher\models\search\KursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kurs boshqaruvchisi';
$this->params['breadcrumbs'][] = $this->title;

//$categoryMap = \yii\helpers\ArrayHelper::map(\backend\modules\categorymanager\models\SubCategory::find()->with('category')->all(), 'id', 'title', 'category.title');

$this->registerAjaxCrudAssets();

?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'bulkButtons' => false,
    'responsive' => false,
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
            'width' => '200px',
            'value' => function ($model) {
                return a($model->title, ['view', 'id' => $model->id], ['class' => 'text-primary', 'data-pjax' => 0]);
            }

        ],
        [

            'attribute' => 'category_id',
            'value' => function ($model) {
                return tag('label', $model->category->title, ['class' => 'label label-info']);
            },
            'width' => '150px',
            'format' => 'raw',
//            'filterInputOptions' => ['class' => 'form-control', 'prompt' => "Barchasi"],
//            'filter' => $categoryMap,

        ],
        [
            'format' => 'raw',
            'label' => "Ma'lumot",
            'encodeLabel' => false,
            'value' => function ($model) {

                /** @var $model frontend\modules\teacher\models\Kurs */

                return "<small class='text-muted'>
                            <a href='" . to(['/teacher/kurs/sections', 'id' => $model->id]) . "' data-pjax='0' class='text-primary'>
                                                        <b>Jami bo'lim: </b> {$model->getSections()->count()};
                                                        (<b>Faol: </b> {$model->getActiveSections()->count()})
                                                        </a>
                            <br>
                            
                            <b>Jami mavzu: </b> {$model->getLessons()->count()};
                            (<b>Faol: </b> {$model->activeLessonsCount })
                            <br>
                             <a href='" . to(['/teacher/kurs/students', 'id' => $model->id]) . "' data-pjax='0' class='text-primary'>
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

                /** @var frontend\modules\teacher\models\Kurs $model */

                return "<small class='text-muted'>
                            <b>Videolar: </b> {$model->videosCount} <br>
                            <b>Davomiyligi: </b> {$model->formattedVideosDuration}
                        </small>";

            }
        ],
        'statusLabel:raw:Holat',
        'actionColumn' => [
            'dropdownOptions' => ['class' => 'pull-right'],
            'dropdownMenu' => ['class' => 'dropdown-menu-right', 'style' => ['z-index' => '999999999']],
            'width' => '150px',
            'template' => '{view}{update}{sections}{students}{add-user}{change-status}{as-student}{delete}',

            'buttons' => [
                'sections' => function ($url, $model) {
                    return a("Bo'limlarni boshqarish", $url, ['class' => 'dropdown-item', 'data-pjax' => 0], 'list');
                },
                'students' => function ($url, $model) {
                    return a("A'zolar", $url, ['class' => 'dropdown-item', 'data-pjax' => 0], 'users');
                },
                'add-user' => function ($url, $model) {
                    return a("Talaba qo'shish", ['select-user', 'id' => $model->id], ['class' => 'dropdown-item', 'data-pjax' => 0], 'user-plus');
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

                'as-student' => function ($url, $model) {
                    return a("Talaba sifatida ko'rish", ['/teacher/start/index', 'id' => $model->id], ['class' => 'dropdown-item', 'data-pjax' => 0, 'target' => '_blank'], 'eye');
                },


            ]
        ],
    ],
]); ?>
