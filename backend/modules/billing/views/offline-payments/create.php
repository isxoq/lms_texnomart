<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\billing\models\OfflinePayments */

$this->title = "Offline to'lov qo'shish";
$this->params['breadcrumbs'][] = ['label' => "Offline to'lovlar", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

