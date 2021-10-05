<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

    use yii\helpers\Html;

    $this->title = Yii::t('app', 'Sms settings');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sms manager'), 'url' => ['/smsmanager']];
    $this->params['breadcrumbs'][] = $this->title;

?>

<div class="availability-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model, $key){

                        if ($model->idn == 'token'){

                            return Html::a('<span class="fa fa-sync-alt">',
                                ['update-token'],
                                [
                                    'class' => 'btn btn-sm btn-info',
                                    'title' => Yii::t('app', 'Update token'),

                                ]);

                        }

                        return Html::a('<span class="fa fa-edit">',
                            ['update-settings', 'id' => $key],
                            ['class' => 'btn btn-sm btn-success']);

                    }
                ]
            ],
            'name',
            [
                'attribute' => 'value',
                'format' => 'raw',
                'contentOptions' => [
                    'style' => 'word-wrap:anywhere',
                ],
            ],
            'updated_at:datetime',

        ],
    ]); ?>
</div>

