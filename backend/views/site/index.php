<?php

use backend\modules\billing\models\Purchases;
use backend\modules\kursmanager\models\Enroll;
use common\models\User;

/* @var $this yii\web\View */

$this->title = "Bosh sahifa";

$totalUsers = intval(User::find()->count());
$todayUsers = intval(User::find()->today()->count());
$totalEnrolls = intval(Enroll::find()->count());
$todayEnrolls = intval(Enroll::find()->today()->count());

$payedEnrolls = intval(Enroll::find()->paid()->count());
$freeEnrolls = intval(Enroll::find()->free()->count());

$todayPayedEnrolls = intval(Enroll::find()->today()->paid()->count());
$todayFreeEnrolls = intval(Enroll::find()->today()->free()->count());


?>


<div class="row">

    <div class="col-xl-3 col-sm-6">
        <div class="card bg-c-yellow text-white">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="m-b-5">Jami foy.chilar</p>
                        <h4 class="m-b-0"><?= as_integer($totalUsers) ?></h4>
                    </div>
                    <div class="col col-auto text-right">
                        <i class="feather icon-users f-50 text-c-yellow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card bg-c-green text-white">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="m-b-5">Bugungi foy.chilar</p>
                        <h4 class="m-b-0"><?= as_integer($todayUsers) ?></h4>
                    </div>
                    <div class="col col-auto text-right">
                        <i class="feather icon-user f-50 text-c-green"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card bg-c-yellow text-white">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="m-b-5">Umumiy a'zoliklar</p>
                        <h4 class="m-b-0"><?= as_integer($totalEnrolls) ?></h4>
                    </div>
                    <div class="col col-auto text-right">
                        <i class="feather icon-users f-50 text-c-yellow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card bg-c-green text-white">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="m-b-5">Bugungi a'zoliklar</p>
                        <h4 class="m-b-0"><?= as_integer($todayEnrolls) ?></h4>
                    </div>
                    <div class="col col-auto text-right">
                        <i class="feather icon-user f-50 text-c-green"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
