<?php

use soft\widget\SButton;
use yii\widgets\Pjax;

/* @var $this backend\components\BackendView */
/* @var $model frontend\modules\teacher\models\Kurs */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(['id' => 'kurs-view-pjax']) ?>

<?= $this->render('_kursMenu', ['model' => $model]); ?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,

    'toolbar' => "
    <div class='btn-group'>
  <button type='button' class='btn btn-outline-success dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    <i class='fa fa-user-plus'></i> Talaba qo'shish
  </button>
  <div class='dropdown-menu'>
    <a class='dropdown-item' href='". to(['select-user', 'id' =>  $model->id ]) ."'>
        Mavjud foydalanuvchilardan qidirish
    </a>
    <a class='dropdown-item' href='". to(['add-user', 'id' =>  $model->id ]) ."'>
        Yangi foydalanuvchi qo'shish
    </a>

  </div>
</div>
<div id='w3' class='btn-group'>
    <a id='w4' class='btn btn-outline-primary' href='".to(['update', 'id' => $model->id])."' title=' data-toggle='tooltip' data-placement='bottom' data-trigger='hover' data-original-title='Tahrirlash'>
        <i class='fa fa-edit'></i> 
    </a>
    <a id='w5' class='btn btn-outline-danger' href='".to(['delete', 'id' => $model->id])."' title='Kursni O`chrish' data-confirm='Siz rostdan ham ushbu elementni o`chirmoqchimisiz?' data-method='post' data-toggle='tooltip' data-placement='bottom' data-trigger='hover' data-original-title='O'chirish'>
        <i class='fa fa-trash-alt'></i> 
    </a>
</div>
    ",


    'attributes' => [
        'title',
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
