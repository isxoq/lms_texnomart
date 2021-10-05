<?php

use soft\kartik\SActiveForm;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\usermanager\models\User */
/* @var $enroll frontend\modules\teacher\models\Enroll */

$this->title = "Foydalanuvchini Kursga a'zo qilish";
$this->params['breadcrumbs'][] = ['label' => "Foydalanuvchilar", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= \soft\adminty\DetailView::widget([
    'model' => $model,
    'toolbar' => false,
    'attributes' => [
        'fullName:raw:Foydalanuvchi',
        'email',
        'phone'
    ]
]) ?>

<?php $form = SActiveForm::begin() ?>

<?= \soft\form\SForm::widget([
    'model' => $enroll,
    'form' => $form,
    'attributes' => [
        'kurs_id:select2' => [
            'label' => 'Kursni tanlang',
            'options' => [
                'data' => map(\backend\modules\kursmanager\models\Kurs::find()->with("user")->asArray()->all(), 'id', function ($model) {
                    return $model['title'] . " (" . $model['user']['firstname'] ." ". $model['user']['lastname'] . ")";
                })
            ]
        ],
    ]
]) ?>

<?= \soft\helpers\SHtml::submitButton() ?>

<?php SActiveForm::end() ?>
