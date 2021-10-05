<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model frontend\modules\teacher\models\Section */

$this->title = "Yangi bo'lim qo'shish";


$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['/teacher']];
$this->params['breadcrumbs'][] = ['label' => $model->kurs->title, 'url' => ['/teacher/kurs/view', 'id' => $model->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => "Bo'limlar", 'url' => ['/teacher/kurs/sections', 'id' => $model->kurs_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-create">

    <h2 class="text-success" align="center"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
