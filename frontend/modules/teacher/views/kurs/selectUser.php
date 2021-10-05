<?php

use kartik\form\ActiveForm;
use soft\bs4\Card;

/* @var $this \yii\web\View */
/* @var $model \frontend\modules\teacher\models\Kurs */

$this->title = "Kursga a'zo qilish";

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-sm-6">

        <?php Card::begin([
                'header' => "<span style='font-size: 20px' class='text-primary'>Mavjud foydalanuvchilar orasidan qidirish</span>"
        ]) ?>
        <?php ActiveForm::begin() ?>

        <div class="form-group highlight-addon field-enroll-amount required">
            <label class="" for="enroll-amount">Foydalanuvchining telefon raqami yoki emailini kiriting</label>
            <input type="text" required class="form-control" name="user" aria-required="true" aria-invalid="false"
                   placeholder="Telefon raqam yoki emailni yozing" autofocus>
            <p class="hint-block">
                Telefon raqamni operator kodi bilan kiriting. <br>
                Masalan: <b>998901234567</b>
            </p>
        </div>

        <button type="submit" class="btn btn-success">Kiritish</button>

        <?php ActiveForm::end() ?>

        <br>
        <br>
        <b>
            <a href="<?= to(['add-user', 'id' => $model->id]) ?>" class="text-primary"> <i class="fa fa-user-plus"></i>
                Yangi foydalanuvchi qo'shish</a>
        </b>
        <?php Card::end() ?>
    </div>
</div>

