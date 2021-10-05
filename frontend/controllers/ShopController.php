<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;

use backend\modules\ordermanager\models\Order;
use backend\modules\ordermanager\models\OrderItem;
use frontend\components\UserHistoryBehavior;
use Yii;
use soft\web\SController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ShopController extends SController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['payment'],
                'rules' => [
                    [
                        'actions' => ['payment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

            UserHistoryBehavior::class,

        ];
    }

    /**
     * Buyurtma uchun to'lov qilish
     * @param string $id Order id
     * @return string
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionPayment($id = '')
    {
        $order = Order::find()->andWhere(['user_id' => user('id'), 'id' => $id])->one();

        if ($order == null) {
            not_found();
        }

        if ($order->status != Order::STATUS_NOT_PAYED) {
            forbidden("Ushbu buyurtma uchun to'lov qilingan");
        }

//        $octoFormtoForm = Yii::$app->octo->generate_form($order->id);

        return $this->render('payment', [

            'order' => $order,
//            'octoForm' => $octoForm

        ]);
    }


    public function actionOfflinePaymentInfo()
    {
            return $this->renderAjax('offlinePaymentInfo');
    }

}