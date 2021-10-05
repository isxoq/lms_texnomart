<?php

use soft\helpers\SHtml;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\usermanager\models\TeacherApplication */

$this->title = "Ariza №" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Arizalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'user.fullName',
        'user.address',
        'user.age',
        'downloadFileButton:raw',
        'statusLabel:raw:Ariza holati',
        'message:text',
        'comment:text',
        [
            'attribute' => 'approveButton',
            'format' => 'raw',
            'visible' => !$model->isConfirmed,
        ],
        'created_at',
    ]

]) ?>