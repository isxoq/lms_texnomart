<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\frontendmanager\models\CourseSlider */

$this->title = 'Yangi qo`shish';
$this->params['breadcrumbs'][] = ['label' => 'Kurs slayder', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

