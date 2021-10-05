<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\frontendmanager\models\IndexInfo */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => "Imkoniyatlar", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="index-info-view">

    <?= \soft\adminty\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title_uz',
            'title_ru',
            'content_uz',
            'content_ru',
            'icon',
        ],
    ]) ?>

</div>
