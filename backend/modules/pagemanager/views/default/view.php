<?php

use yii\helpers\Html;

use yii\widgets\DetailView;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\pagemanager\models\Page */

$this->title = substr($model->title, 0, 80);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


    <?= \soft\adminty\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'idn',
            'status',
            'created_at',
            'updated_at',

        ],
    ]) ?>

    <div class="card">
        <div class="card-header">
            <h1><?= t('Content') ?></h1>

        </div>
        <div class="card-body">
            <?= $model->description ?>

        </div>
    </div>

