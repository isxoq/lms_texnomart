<?php

use soft\helpers\SHtml;
use soft\helpers\SUrl;
use soft\kartik\SDetailView;

/* @var $this soft\web\SView */
/* @var $model backend\models\Social */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Socials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="social-view">

    <h1><?= SHtml::encode($this->title) ?></h1>

    <p>
        <?= SHtml::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= SHtml::a('Delete', ['/general/delete-model', 'modelClass' => $model->className(), 'id' => $model->id, 'returnUrl' => SUrl::to(['index']) ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= SDetailView::widget([
        'model' => $model,
        'panel' => [
            'heading' => $model->name,
        ],
        'buttons1' => false,
        'attributes' => [
            ['group' => true, 'label' => Yii::t('app' ,'Details')],
            'id',
            'icon',
            'name',
            'url:url',
            'status',
        ],
    ]) ?>

</div>
