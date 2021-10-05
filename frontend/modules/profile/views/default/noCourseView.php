<?php

/* @var $this \yii\web\View */

$this->title = "Mening kurslarim";

?>



<div class="card">
    <div class="card-body p-20 z-depth-top-0 waves-effect">
        <p class="text-sm-center f-16 text-muted">
            Hurmatli foydalanuvchi! <br>
            Hozirda siz hech qanday kurslarga a'zo bo'lmagansiz! <br>
            <a class="f-16 text-success" href="<?= to(['/course/all']) ?>">Barcha kurslar</a> bo'limidan o'zinigizga
            kerakli kursni tanlang va a'zo bo'ling.
            <br>
            <br>
            <a class="btn btn-outline-danger" href="<?= to(['/course/all']) ?>">Barcha kurslarga o'tish</a>
        </p>
    </div>
</div>