<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\faqmanager\models\Faq */

$this->title = "Tahrirlash";
$this->params['breadcrumbs'][] = ['label' => 'FAQ  Savollar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

