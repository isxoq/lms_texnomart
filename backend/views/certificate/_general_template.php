<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 01.05.2021, 15:00
 */

/** @var \backend\models\Certificate $model */

?>




<?php

/* @var $this \yii\web\View */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body >
<div class="certificate"  style="position: relative; width: 793px!important; height: 1122px!important; background-size: cover; background: url('/certificate_vd/img/cert_original.jpg') no-repeat;" >
    <div class="certificate__fname" style="padding-top: 450px">
        <p class="certificate__fname--text" style="margin: 10px 0 0 0; height: 60px">
            <?= $model->user->fullname ?>
        </p>
        <p class="certificate__course--text" style="position: absolute; top: 50%; margin: 20px 0 0 0">
            <?= $model->kurs->title ?>
        </p>
    </div>
    <div class="certificate__info">
        <h2 class="date">
            Berilgan vaqti: <?= $model->finishedDate ?>
            <br>
            Sertifikat: VD<?= $model->id ?>
        </h2>

    </div>
</div>
</body>
</html>
