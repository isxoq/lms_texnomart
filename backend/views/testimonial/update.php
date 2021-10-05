<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\models\Testimonial */

$this->title = 'Tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Mijozlar fikri', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="testimonial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
