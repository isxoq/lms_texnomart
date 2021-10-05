<?php

use soft\kartik\SActiveForm;
use soft\bs4\Card;
use backend\modules\kursmanager\models\Enroll;

/* @var $this backend\components\BackendView */
/* @var $user backend\modules\usermanager\models\User */
/* @var $kurs backend\modules\kursmanager\models\Kurs */
/* @var $enroll Enroll */

$this->title = "Kursga a'zo qilish";

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $kurs->title, 'url' => ['view', 'id' => $kurs->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
        <?= \soft\adminty\DetailView::widget([
            'model' => $user,
            'toolbar' => false,
            'before' => "Talaba haqida ma'lumot<br><br>",
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
    <div class="col-md-6">
        <?= \soft\adminty\DetailView::widget([
            'model' => $enroll,
            'toolbar' => false,
            'before' => "A'zolik haqida ma'lumot<br><br>",
            'attributes' => [
                "sold_price:integer:Sotilgan narxi",
                [
                    'label' => "A'zolik muddati",
                    'value' => $kurs->durationText,
                    'format' => 'raw',
                ],
                [
                    'label' => "Tugash sanasi",
                    'value' => $enroll->end_at,
                    'format' => 'dateUz',
                ],
            ]
        ]) ?>

        <?php $form = SActiveForm::begin() ?>
        <?= \soft\helpers\SHtml::submitButton("A'zolikni tasdiqlash") ?>
        <?php SActiveForm::end() ?>

    </div>
</div>

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

