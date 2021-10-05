<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\usermanager\models\User */

$this->title = "Yangi foydalanuvchi qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Foydalanuvchilar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

