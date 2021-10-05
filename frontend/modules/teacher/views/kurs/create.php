<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model frontend\modules\teacher\models\Kurs */

$this->title = 'Yangi kurs qo`shish';
$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
