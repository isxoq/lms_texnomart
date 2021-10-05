<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\frontendmanager\models\CourseFeature */

$this->title = 'Update Course Feature: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Course Features', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

