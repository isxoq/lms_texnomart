<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 07.08.2021, 10:49
 */

namespace console\controllers;

use backend\modules\kursmanager\models\Enroll;
use yii\console\Controller;

class MyController extends Controller
{


    public function actionPaidEnrolls()
    {

        Enroll::updateAll(['sold_price' => 199000], ['kurs_id' => 2, 'sold_price' => 0]); // photoshop
        Enroll::updateAll(['sold_price' => 170000], ['kurs_id' => 18, 'sold_price' => 0]); // php
        Enroll::updateAll(['sold_price' => 99000], ['kurs_id' => 20, 'sold_price' => 0]); //kompas 3d
        Enroll::updateAll(['sold_price' => 125000], ['kurs_id' => 19, 'sold_price' => 0]); //after effects
        Enroll::updateAll(['sold_price' => 199000], ['kurs_id' => 23, 'sold_price' => 0]); // yii2
        Enroll::updateAll(['sold_price' => 90000], ['kurs_id' => 26, 'sold_price' => 0]); // c++
        Enroll::updateAll(['sold_price' => 150000], ['kurs_id' => 30, 'sold_price' => 0]); // c++ builder


    }

}