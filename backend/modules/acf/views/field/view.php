<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\acf\models\Field;

/* @var $this yii\web\View */
/* @var $model backend\modules\acf\models\Field */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//echo Yii::$app->acf->getValue($model->name);

?>

<div class="field-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">

            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'name',
                    'description',
                    'fieldTypeName',
                    'options:ntext',
                    'is_required:boolean',
                    'is_multilingual:boolean',
                    'is_active:boolean',
                    'placeholder',
                    'prepend',
                    'append',
                    'character_limit',
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= Html::beginForm(['update-value', 'id' => $model->id]) ?>
            <p>
                <?= Html::submitButton(Yii::t('app', 'Update value'), ['class' => 'btn btn-primary']) ?>
            </p>
            <?= $model->field() ?>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>
