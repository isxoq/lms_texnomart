<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 01.05.2021, 14:04
 */

/* @var $this \yii\web\View */
/* @var $certicates \backend\models\Certificate[] */

$this->title = 'Mening sertifikatlarim';
$date = $certicates[0]->date;

?>

<div class="row users-card">
    <?php foreach ($certicates as $certicate): ?>

        <div class="col-lg-6 col-xl-3 col-md-6">
            <div class="card rounded-card user-card">
                <div class="card-block">
                    <div class="">
                        <img class="img-fluid img-radius" src="<?= $certicate->kurs->kursImage ?>"
                             alt="round-img">
                    </div>
                    <div class="user-content">
                        <h4 class=""><?= e($certicate->kurs->title) ?></h4>
                        <p class="m-b-0 text-muted">
                            <a href="<?= to(['view', 'id' => $certicate->id]) ?>" class="btn btn-primary btn-block" target="_blank">
                                <span class="feather icon-eye"></span> Sertifikatni ko'rish
                            </a>
                            <a href="<?= to(['download', 'id' => $certicate->id]) ?>" class="btn btn-warning btn-block" target="_blank">
                                <span class="feather icon-download"></span> Yuklab olish
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>
