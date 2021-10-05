<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\pagemanager\models\Page */

$this->title = "Tahrirlash: " . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Tahrirlash"
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
