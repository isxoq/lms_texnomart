<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\faqmanager\models\Faq */

$this->title = "Yangi qo'shish - FAQ";
$this->params['breadcrumbs'][] = ['label' => 'FAQ  Savollar', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Yangi qo'shish";


?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
