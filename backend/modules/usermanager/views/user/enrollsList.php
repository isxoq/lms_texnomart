<?php

use backend\modules\kursmanager\models\Enroll;
use yii\widgets\Pjax;

/* @var $this \soft\web\SView */
/* @var $model \backend\modules\usermanager\models\User */
/* @var $dataProvider \yii\data\ActiveDataProvider */


$this->title = "A'zoliklar - " . $model->fullname;
$this->params['breadcrumbs'][] = ['label' => "Foydalanuvchilar", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "A'zoliklar";

$this->registerAjaxCrudAssets();

?>

<?php Pjax::begin(['id' => 'user_view'])  ?>

<?= $this->render('_userMenu', ['model' => $model]) ?>

<?= \soft\adminty\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'cols' => [
        [
            'attribute' => 'kurs_id',
            'value' => function ($model) {
                /** @var Enroll $model */
                $kursName = $model->kurs->title;
                $teacherName = tag('small', fa("user") ." ". $model->kurs->user->fullname);
                return a($kursName. BR . $teacherName, ['/kursmanager/kurs/view', 'id' => $model->kurs->id], ['data-pjax' => 0, 'class' => 'text-primary']);
            },
            'format' => 'raw',
        ],
        'sold_price:sum:To`lov',
        [
            'label' => "A'zolik",
            'value' => function ($model) {
                /** @var Enroll $model */
               $text = $model->getDurationField();
                return tag('small', $text);
            },
            'format' => 'raw',
            'filter' => false,
        ],

        [
            'attribute' => 'Darslar',
            'value' => function ($model) {
                /** @var Enroll $model */
                $text = $model->getUserLessonsInfo();
                return tag('small', $text);
            },
            'format' => 'raw',
            'filter' => false,

        ],

        'actionColumn' => [
            'template' => '{view}{delete}',
            'controller' => '/kursmanager/enroll'
        ],
    ],
]); ?>

<?php Pjax::end()  ?>