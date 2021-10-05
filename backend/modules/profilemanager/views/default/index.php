<?php

use yii\helpers\Html;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */
/** @var backend\modules\profilemanager\models\ProfileUser $model */

$this->title = t('Personal cabinet');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary'], 'pencil') ?>
        <?= a(Yii::t('app', 'Change password'), ['change-password'], ['class' => 'btn btn-warning'], 'key') ?>
    </p>

    <?= \soft\adminty\DetailView::widget([
        'model'=>$model,
        'attributes'=>[
            'username',
            'lastname',
            'firstname',
            'email',
        ]
    ]); ?>
</div>

