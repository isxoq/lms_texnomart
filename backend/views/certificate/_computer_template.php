<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 01.05.2021, 15:00
 */

function nbsp($count = 1)
{
    for ($i = 0; $i < $count; $i++) {
        echo "&nbsp;";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="">


<div class="certificate"
     style="background-image: url('/certificate/images/background.jpg'); padding-left: 140px; padding-right: 140px">
    <div class="content" style="">

        <br><br>
        <br><br>
        <br><br>
        <img src="/certificate/images/logo.png" alt="" style="width: 160px; ">
        <br>
        <span class="cert-info">
            <?php nbsp(170); ?>
            <span class="cert-no" style="font-weight: bold; font-size: 20px">Sertifikat: VD9999999</span>
            <br>

        </span>

        <br>

        <span class="title" style="font-size: 80px">sertifikat</span>
        <br>
        <div class="full-name" style="font-size: 25px">
            Nurmuhammedov Ro'zimuhammad
        </div>
        <br>
        <span class="direction" style="font-size: 30px">kompyuter savodxonligi</span>

        <br>
        <span class="because" style="font-weight: bold; font-size: 18px">bo'yicha 36 soatlik kursni muvaffaqiyatli tamomlaganligi uchun berildi</span>
        <br>
        <span class="bacause-sub" style="font-size: 17px">Microsoft Office dasturlari (MS Word, MS Excel, MS
            PowerPoint)<br>
            hamda Internetda ishlash bo'yicha malaka orttirganligi uchun.
        </span>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <div style="text-align: justify">

            <?php nbsp(175); ?>
            ____________ F.MUYDINOV
            <br>
            <?php nbsp(5); ?>

            <span style="font-weight: bold">
                                Berilgan vaqti: 31.03.2021y.
                                </span>
            <?php nbsp(140); ?>
            <span>
                markaz rahbari

            </span>

        </div>
        <br>

    </div>


</div>
</body>
</html>