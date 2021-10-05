<?php

namespace frontend\modules\teacher\controllers;

use frontend\components\UserHistoryBehavior;
use Yii;
use soft\web\SController;

/**
 * Default controller for the `teacher` module
 */
class DefaultController extends SController
{
    public function behaviors()
    {
        return[
            UserHistoryBehavior::class,
        ];
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionInfo()
    {
        return $this->render('index');
    }

    public function actionChart()
    {
        return $this->render('chart');
    }

}
