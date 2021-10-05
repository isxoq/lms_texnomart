<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\frontendmanager\models\CourseSlider */

$this->title = 'Tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Kurs slayder', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

