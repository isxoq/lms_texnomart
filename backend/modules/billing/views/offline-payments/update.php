<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\billing\models\OfflinePayments */

$this->title = Yii::t('app', 'Update Offline Payments: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => "Offline to'lovlar", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="offline-payments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
