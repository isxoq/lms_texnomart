<?php

use soft\bs4\Card;
use common\models\User;
use soft\kartik\SActiveForm;
use soft\form\SForm;

/* @var $this \yii\web\View */
/* @var $model \frontend\modules\teacher\models\Kurs|null */
/* @var $user \common\models\User */

$this->title = "Yangi foydalanuvchi qo'shish";

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-sm-12">

        <?php Card::begin([
            'header' => "<span style='font-size: 20px' class='text-primary'>Yangi foydalanuvchi qo'shish</span>"
        ]) ?>

        <?php $form = SActiveForm::begin(); ?>

        <?= SForm::widget([

            'form' => $form,
            'model' => $user,
            'columns' => 2,
            'attributes' => [
                'firstname',
                'lastname',
                'phone' => [
                    'hint' => "Telefon raqamni to'liq kiriting. Masalan: 998911234567"
                ],
                'email',
                'password' => [
                    'options' => [
                        'type' => 'text'
                    ],
                    'label' =>'Parol',
                ],
            ]

        ]) ?>

        <?= \soft\helpers\SHtml::submitButton() ?>

        <?php SActiveForm::end() ?>

        <br>
        <br>
        <b>
            <a href="<?= to(['select-user', 'id' => $model->id]) ?>" class="text-primary"> <i class="fa fa-search"></i>
                Mavjud foydalanuvchilar orasidan qidirish</a>
        </b>

        <?php Card::end() ?>
    </div>
</div>
