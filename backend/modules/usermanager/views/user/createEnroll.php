<?php

use soft\kartik\SActiveForm;
use soft\bs4\Card;
use backend\modules\kursmanager\models\Enroll;

/* @var $this backend\components\BackendView */
/* @var $user backend\modules\usermanager\models\User */
/* @var $kurs backend\modules\kursmanager\models\Kurs */
/* @var $enroll Enroll */

$this->title = "Foydalanuvchini Kursga a'zo qilish";
$this->params['breadcrumbs'][] = ['label' => "Foydalanuvchilar", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->fullName, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
        <?= \soft\adminty\DetailView::widget([
            'model' => $user,
            'toolbar' => false,
            'before' => "Foydalanuvchi haqida ma'lumot<br><br>",
            'attributes' => [
                'fullName:raw:Foydalanuvchi',
                'email',
                'phone'
            ]
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= \soft\adminty\DetailView::widget([
            'model' => $kurs,
            'toolbar' => false,
            'before' => "Kurs haqida ma'lumot<br><br>",
            'attributes' => [
                'title',
                "user.fullname:raw:O'qituvchi",
                [
                    'label' => "Narxi",
                    'value' => $kurs->is_free ? "Bepul" : $kurs->formattedPrice,
                ]
            ]
        ]) ?>
    </div>
</div>

<?php Card::begin([
    'header' => "A'zolik ma'lumotlari"
]) ?>
<?php $form = SActiveForm::begin() ?>

<?= $form->errorSummary($enroll) ?>

<?= \soft\form\SForm::widget([
    'model' => $enroll,
    'form' => $form,
    'columns' => 3,
    'attributes' => [
        'type:select2' => [
            'label' => "To'lov  turi",
            'options' => [
                'data' => [
                    Enroll::TYPE_FREE => "Bepul",
                    Enroll::TYPE_PURCHASED => "Sotib olingan",
                ]
            ]
        ],
        'sold_price',
        'end_at:widget' => [
            'label' => "A'zolikning Tugash sanasi",
            'widgetClass' => '\kartik\datetime\DateTimePicker',
            'options' => [
                'pluginOptions' => [
                    'language' => 'ru',
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'autoclose' => true,
                ]
            ]
        ],
    ]
]) ?>
<?= \soft\helpers\SHtml::submitButton() ?>
<?php SActiveForm::end() ?>
<?php Card::end() ?>

<?php if (!$enroll->isNewRecord): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                Diqqat! Ushbu foydalanuvchi avvalroq ushbu kursga a'zo bo'lgan
            </div>
        </div>
        <div class="col-md-6">
            <?= \soft\adminty\DetailView::widget([
                'model' => $enroll,
                'toolbar' => false,
                'before' => "Avvalgi a'zolik haqida ma'lumot<br><br>",
                'attributes' => [
                    [
                        'label' => "A'zo bo'lgan sana",
                        'value' => Yii::$app->formatter->asDateTimeUz($enroll->oldAttributes['created_at'])
                    ],
                    [
                        'label' => "A'zolikning tugash sanasi",
                        'value' => Yii::$app->formatter->asDateTimeUz($enroll->oldAttributes['end_at'])
                    ],
                ]
            ]) ?>
        </div>

    </div>
<?php endif ?>

