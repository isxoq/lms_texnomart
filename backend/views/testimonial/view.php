<?php

use soft\helpers\SHtml;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */
/* @var $model backend\models\Testimonial */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mijozlar fikri', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title_uz',
        'title_ru',
        'text_uz',
        'text_ru',
        'user.fullname',
        'created_at',
        'updated_at',
        'status',
    ],
]) ?>
