<?php


namespace frontend\modules\teacher\controllers;

use backend\modules\billing\models\Purchases;
use yii;
use yii\base\Controller;
use yii\filters\VerbFilter;

class AjaxController extends Controller
{


    public function actionMonthlyStudents()
    {


        $chartElements = [];

        $startMoth = new \DateTime(date('01.m.Y'));

        $endDate = new \DateTime(date('d.m.Y', strtotime('-1 days', strtotime('+1 month', strtotime(date('01.m.Y'))))));

        for ($i = $startMoth; $i <= $endDate; $i->modify('+1 days')) {

            $count = user()->getEnrolledUsers()
                ->andWhere(['between', 'created_at', strtotime($i->format('d.m.Y 00:00:00')), strtotime($i->format('d.m.Y 23:59:59'))])
                ->count();

            if (true) {
                $chartElements[] = [
                    'date' => $i->format('Y-m-d'),
                    'soni' => $count
                ];
            }


        }
        return $this->sendResponse($chartElements);

    }


    public function actionMonthlyRevenue()
    {


        $chartElements = [];


        $startMoth = new \DateTime(date('01.m.Y'));

        $endDate = new \DateTime(date('d.m.Y', strtotime('-1 days', strtotime('+1 month', strtotime(date('01.m.Y'))))));

        for ($i = $startMoth; $i <= $endDate; $i->modify('+1 days')) {

            $summ = Purchases::find()
                ->andWhere(['between', 'created_at', strtotime($i->format('d.m.Y 00:00:00')), strtotime($i->format('d.m.Y 23:59:59'))])
                ->andWhere(['user_id' => user('id')])
                ->sum('amount');


            if (true) {
                $chartElements[] = [
                    'date' => $i->format('Y-m-d'),
                    'amount' => $summ
                ];
            }


        }
        return $this->sendResponse($chartElements);

    }

    public function actionTest()
    {
        return $this->sendResponse([
            'a' => 1,
            'sf' => 1,
            'sdf' => 1
        ]);
    }


    public function sendResponse($data)
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        return yii\helpers\Json::encode($data);
    }

}