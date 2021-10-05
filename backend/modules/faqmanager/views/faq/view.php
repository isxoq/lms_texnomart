<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\faqmanager\models\Faq */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'FAQ  Savollar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

    <?= \soft\adminty\DetailView::widget([
        'model' => $model,
//        'toolbar' => false,
        'breakWords' => true,
        'attributes' => [
            'category.title',
            'title_uz',
            'text_uz:raw',

            'title_ru',
            'text_ru:raw',

            'status',
        ],
    ]) ?>

