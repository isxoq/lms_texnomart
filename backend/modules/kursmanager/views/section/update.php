<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model frontend\modules\teacher\models\Section */

$this->title = "Bo'limni tahrirlash";
$this->params['breadcrumbs'][] = ['label' => 'Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

