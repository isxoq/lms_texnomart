<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\frontendmanager\models\CourseFeature */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Course Features', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\adminty\DetailView::widget([

    'model' => $model,
    'attributes' => [

        'title_uz',
        'text_uz',
        'title_ru',
        'text_ru',
        'icon',
        'url:url',
        'status',

    ]


]) ?>