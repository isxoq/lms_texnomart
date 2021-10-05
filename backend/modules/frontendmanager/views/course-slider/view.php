<?php

use soft\helpers\SHtml;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\frontendmanager\models\CourseSlider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Kurs slayder', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'course.title',

        'title',
        'text',
        'icon',
        'image',
        'little_image:littleImage',
        'status',
    ],
]) ?>

