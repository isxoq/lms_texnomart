<?php

use soft\kartik\SActiveForm;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $slides \backend\modules\frontendmanager\models\CourseSlider[] */


$this->title = 'Saralash';
$this->params['breadcrumbs'][] = ['label' => 'Kurs slayder', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = SActiveForm::begin() ?>


<?= \unclead\multipleinput\MultipleInput::widget([

//    'model' => $slides[0],
//    'attribute' => 'sort_order',
    'sortable' => true,
    'name' => 'sortable',
    'data' => $slides,

    'columns' => [
        [
            'name' => 'id',
            'options' => [
                'class' => 'd-none',
            ]
        ],
        [
            'name' => 'title',
            'value' => function ($data) {
                return $data->course->title ?? '';
            },
        ],
    ],

    'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
    'addButtonOptions' => ['class' => 'd-none'],
    'cloneButtonOptions' => ['class' => 'd-none'],
    'removeButtonOptions' => ['class' => 'd-none'],

]) ?>

<?= \soft\helpers\SHtml::submitButton() ?>

<?php SActiveForm::end() ?>


