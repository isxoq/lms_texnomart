<?php


/* @var $this backend\components\BackendView */
/* @var $model backend\modules\kursmanager\models\Enroll */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Enrolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'user.fullname:raw:Student',
//        'user.email',
//        'user.phone',
        'kurs.title',
        'kurs.user.fullname:raw:Kurs muallifi',
        'end_at:dateUz:Tugaydi',
        'created_at',
        'updated_at',
        'sold_price',
        'type',
    ],
]) ?>
