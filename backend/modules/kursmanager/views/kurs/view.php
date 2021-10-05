<?php

use yii\widgets\Pjax;

/* @var $this backend\components\BackendView */
/* @var $model frontend\modules\teacher\models\Kurs */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$this->registerAjaxCrudAssets();

?>

    <?php Pjax::begin(['id' => 'kurs-view-pjax']) ?>

    <?=  $this->render('_kursMenu', ['model' => $model]); ?>

    <?= \soft\adminty\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'user.fullname',
            'kursImage:littleImage',
            'short_description:text',
            'description:raw',
            'category.title',
            'levelText',
            'languageText',

//            'is_best:bool',

            'is_free:bool',
            'price:sum',
            'old_price:sum',

            'durationText',
//            'freeDurationText',

//            'preview_host',
            'preview_link:url',


            'statusLabel:raw',
            'benefitsList:raw',
            'requirementsList:raw',

            'meta_keywords',
            'meta_description',

            'created_at:dateTimeUz',
            'updated_at:dateTimeUz',
        ],
    ]) ?>

    <?php Pjax::end() ?>
