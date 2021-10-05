<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model \backend\modules\acf\models\Field */

$this->title = Yii::t('app', 'Update Field Value: {name}', [
    'name' => $model->title,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update value');

?>

<h1><?= $model->title ?></h1>

<?= Html::beginForm('', 'post', [
        'enctype' => 'multipart/form-data'
]) ?>
<?= $model->field() ?>
<?= Html::submitButton( Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
<?= Html::endForm() ?>


