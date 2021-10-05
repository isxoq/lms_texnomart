<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\models\usermanager\models\TeacherApplication */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Teacher Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

