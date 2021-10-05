<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\models\EducationLevel */

$this->title = 'Create Education Level';
$this->params['breadcrumbs'][] = ['label' => 'Education Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

