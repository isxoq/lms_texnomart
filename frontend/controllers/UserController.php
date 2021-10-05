<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;


use common\models\User;
use frontend\components\UserHistoryBehavior;
use frontend\models\Kurs;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserController extends FrontendController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

            UserHistoryBehavior::class

           /* 'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'place-order' => ['post'],
                ],
            ],*/
        ];
    }

    public function actionMyCourses()
    {


    }



}