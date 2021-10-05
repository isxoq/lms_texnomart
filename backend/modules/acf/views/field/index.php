<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\modules\acf\models\Field;
use backend\modules\acf\models\FieldType;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\acf\models\search\FieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fields');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Field'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'name',
                'headerOptions' => [
                    'width' => '15%'
                ]
            ],
            [
                'attribute' => 'type_id',
                'value' => function ($model) {
                    /** @var Field $model */
                    return $model->fieldTypeName;
                },
                'filter' => ArrayHelper::map(FieldType::find()->all(), 'id', 'name')
            ],
            [
                'label' => 'Value',
                'value' => function ($model) {
                    /** @var Field $model */
                    return Yii::$app->acf->getValue($model->name);
                },
                'format' => 'raw',
            ],
            'description',
//            'options:ntext',
            //'is_required',
//            'is_multilingual:boolean',
            //'placeholder',
            //'prepend',
            //'append',
            //'character_limit',
            //'status',

            [
                'header' => 'Actions',
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => [
                    'width' => '10%'
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
