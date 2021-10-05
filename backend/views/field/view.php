<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Field */
?>
<div class="field-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'value',
                'format' => 'raw',
                'value' => function($model){

                    if($model->type == 'Rasm'){
                        return Html::img($model->value, ['width' => '100px', 'max-height' => '300px']);
                    }
                    else{
                        return $model->value;
                    }

                }
            ],
            'url',
            // 'type',
            'status',
        ],
    ]) ?>

</div>
