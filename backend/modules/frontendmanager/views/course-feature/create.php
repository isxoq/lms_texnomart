<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\frontendmanager\models\CourseFeature */

$this->title = 'Create Course Feature';
$this->params['breadcrumbs'][] = ['label' => 'Course Features', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

