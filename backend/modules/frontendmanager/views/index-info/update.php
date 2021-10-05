<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\frontendmanager\models\IndexInfo */

$this->title = "Tahrirlash";
$this->params['breadcrumbs'][] = ['label' => "Imkoniyatlar", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Tahrirlash";
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

