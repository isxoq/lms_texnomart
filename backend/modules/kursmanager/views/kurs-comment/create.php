<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\kursmanager\models\KursComment */

$this->title = 'Create Kurs Comment';
$this->params['breadcrumbs'][] = ['label' => 'Kurs Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kurs-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
