<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\kursmanager\models\KursComment */

$this->title = 'Tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Kurs Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Comment №'. $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
