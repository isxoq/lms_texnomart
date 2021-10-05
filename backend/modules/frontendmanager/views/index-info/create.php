<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\frontendmanager\models\IndexInfo */

$this->title = "Yangi qo'shish";
$this->params['breadcrumbs'][] = ['label' => "Imkoniyatlar", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

