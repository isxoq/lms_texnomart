<?php

use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\Kurs;
use common\models\User;
use soft\adminty\GridView;

/* @var $this backend\components\BackendView */
/* @var $searchModel backend\modules\kursmanager\models\search\EnrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "A'zoliklar";
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();

$coursesMap = map(Kurs::find()->asArray()->all(), 'id', 'title');
$teachersMap = map(User::find()->andWhere(['type' => User::TYPE_TEACHER])->all(), 'id', 'fullname');

?>

<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'bordered' => true,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => "{export}{refresh}",
    'breakWords' => false,
    'showPageSummary' => true,
    'cols' => [
        [
            'attribute' => 'userFullname',
            'label' => 'Talaba',
            'value' => function ($model) {
                return tag('small', $model->user->fullname);
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'userPhone',
            'label' => 'Tel. raqam',
            'value' => function ($model) {
                return tag('small', $model->user->phone);
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'kurs_id',
            'value' => function ($model) {
                return tag('small', $model->kurs->title);
            },
            'width' => "150px",
            'format' => 'raw',
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => $coursesMap,
                'options' => [
                    'placeholder' => 'Kursni tanlang...',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ],
        ],

        [

            'attribute' => 'sold_price',
            'format' => 'integer',
            'pageSummary' => true,
        ],

        [
            'attribute' => 'teacherId',
            'label' => "O'qituvchi",
            'value' => function ($model) {
                return tag('small', $model->kurs->user->fullname);
            },
            'width' => "150px",
            'format' => 'raw',
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => $teachersMap,
                'options' => [
                    'placeholder' => 'Tanlang...',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ],

        ],

        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                $text = Yii::$app->formatter->asDateUz($model->created_at);
                $createdBy = $model->createdBy;
                if ($createdBy != null) {

                    $text .= "<br>" . fa('user') . " " . $createdBy->fullname;

                }
                return tag('small', $text);
            },
            'format' => 'raw',
            'width' => "120px",
            'filter' => false,

        ],
        [
            'attribute' => 'end_at',
            'label' => "Tugash sanasi",
            'filter' => false,
            'value' => function ($model) {
                return tag('small', Yii::$app->formatter->asDateUz($model->end_at));
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'Darslar',
            'value' => function ($model) {
                /** @var Enroll $model */
                $text = $model->getUserLessonsInfo();
                return tag('small', $text);
            },
            'width' => "150px",
            'format' => 'raw',
            'filter' => false,

        ],

        'actionColumn',
    ],
]); ?>
