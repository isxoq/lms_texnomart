<?php

use backend\modules\usermanager\models\TeacherApplication;
use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\usermanager\models\search\TeacherApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Arizalar";
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\adminty\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'id' => 'crud-datatable',
    'toolbarTemplate' => "{refresh}",
    'bulkButtonsTemplate' => "{delete}",
    'cols' => [
        'checkboxColumn',
        [
            'attribute' => 'username',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var TeacherApplication $model */
                $link = a($model->user->fullname, ['user/view', 'id' => $model->user->id], ['class' => 'text-primary', 'data-pjax' => 0]);
                $phone = Html::tag('span', Yii::$app->formatter->asFormattedShortPhoneNumber($model->user->phone));
                return $link . "<br>" . $phone;
            }
        ],
        [
            'attribute' => 'status',
            'filter' => [
                TeacherApplication::STATUS_NEW => 'Yangi',
                TeacherApplication::STATUS_WAITING => 'Kutish rej.',
                TeacherApplication::STATUS_ACCEPTED => 'Tasdiqlangan',
                TeacherApplication::STATUS_CANCELLED => 'Bekor qilindi',
            ],
            'format' => 'raw',
            'value' => function ($model) {
                /** @var TeacherApplication $model */
                return $model->statusLabel;
            }
        ],
        'created_at' => [
            'width' => '150px',
        ],
        'speciality:raw',
        'is_ready:boolean:Tayyor',

        'downloadFileButton:raw:Fayl',
        [
            'attribute' => 'comment',
            'format' => 'small',
        ],
        'actionColumn' => [
            'width' => '250px',
            'template' => "{view}{approve}{update}{delete}",
            'updateOptions' => [
                'role' => 'modal-remote'
            ],
            'visibleButtons' => [
                'approve' => function ($model) {
                    /** @var  TeacherApplication $model */
                    return !$model->isConfirmed;
                },

            ],
            'buttons' => [
                'approve' => function ($url, $model) {
                    /** @var \backend\modules\usermanager\models\TeacherApplication $model */
                    return $model->getApproveButton(['class' => 'dropdown-item']);
                }
            ]
        ],
    ],
]); ?>
