<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$this->title = $model->id."-murojaat";
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\adminty\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'firstname',
            'lastname',
            'phone',
            'email:email',
            [
                'attribute' => 'body',
                'format' => 'raw',
                'value' => function ($data){
                    return "<p style='display:block; width: 500px'>".$data->body."</p>";
                }
            ],
            'status',
            'created_at',
        ],
    ]) ?>
