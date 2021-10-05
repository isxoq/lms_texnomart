<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\faqmanager\models\FaqCategory */
/* @var $models backend\modules\faqmanager\models\Faq[] */

$this->title = 'Update Faq Category: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faq Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faq-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'models' => $models,
    ]) ?>

</div>
