<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\acf\models\FieldType */

$this->title = Yii::t('app', 'Create Field Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Field Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
