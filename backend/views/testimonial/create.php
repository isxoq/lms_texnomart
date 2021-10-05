<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\models\Testimonial */

$this->title = "Yangi qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Mijozlar fikri', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testimonial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
