<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;

use Yii;
use soft\web\SController;

class FrontendController extends SController
{

    public function init()
    {
        parent::init();
        Yii::$app->site->setLanguage();
    }

}