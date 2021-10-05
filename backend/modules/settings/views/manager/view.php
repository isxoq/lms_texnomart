<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\settings\models\Settings */




?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'description',
        'type',
        'section',
        'key',
        [
            'label' => "Qiymati",
            'format' => 'raw',
            'value' => function($model){

                /** @var backend\modules\settings\models\Settings $model */
                if ($model->is_multilingual){

                    $langs = array_keys(Yii::$app->site->languages());
                    $value = json_decode($model->value);
                    $result = '';
                    foreach ($langs as $lang){
                        $result .= tag('h3', $lang);
                        $result .= Yii::$app->formatter->asHtml($value->$lang);
                    }
                    return $result;


                }
                else{
                    return $model->formattedValue;
                }


            }
        ]
    ],
]) ?>

