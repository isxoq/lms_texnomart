<?php

/* @var $this \yii\web\View */

$this->title = 'Mening sertifikatlarim';

?>


<div class="card">
    <div class="card-body p-20 z-depth-top-0 waves-effect">
        <p class="text-sm-center f-16 text-muted">
            <b> Hurmatli foydalanuvchi!</b>
            <br>
            <br>
            Hozirda sizda sertifikatlar mavjud emas!
            <br>

        <h5 class="text-success" align="center">
            O'zingiz a'zo bo'lgan kurslarni to'liq tugating va sertifikatga ega bo'ling!
        </h5>
        <br>
        <h5 class="text-warning" align="center" style="font-weight: bold">
            Sertifikat faqatgina pullik kurslar uchun beriladi!
        </h5>
        <br>
        <br>

        </p>

        <p align="center">
            <a href="<?= to(['view-example']) ?>" class="btn btn-outline-info" target="_blank">Sertifikat namunasini ko'rish</a>

        </p>

    </div>
</div>