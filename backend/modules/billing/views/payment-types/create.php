<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\billing\models\PaymentTypes */

$this->title = Yii::t('app', 'Create Payment Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
