<?php

use soft\helpers\SHtml;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */
/* @var $model backend\models\Partner */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'image',
        'link',
        'status',
    ],
]) ?>

