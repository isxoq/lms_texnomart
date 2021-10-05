<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;

use backend\modules\billing\models\Purchases;
use backend\modules\ordermanager\models\Order;
use backend\modules\octouz\models\OctouzTransactions;
use backend\modules\ordermanager\models\OrderItem;
use Yii;
use soft\web\SController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

class OctoController extends SController
{

    public $enableCsrfValidation = false;
    const OCTO_REQUEST_URL = "https://secure.octo.uz/prepare_payment";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['order-success'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['callback', 'test-purchase'],
                        'allow' => true,
                        'roles' => ['@', '?']
                    ]
                ],
            ],

        ];
    }


    public function actionCallback(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;


        $postData = file_get_contents('php://input');
        // Request Payload
        $requestData = json_decode($postData, true);

        if (json_last_error() !== JSON_ERROR_NONE) { // handle Parse error
            return [
                'status' => 'error',
                'message' => 'incorrect input json'
            ];
        }

        if ($requestData['status'] == "waiting_for_capture") {
            return $this->capture($requestData);
        }

        $transaction = OctouzTransactions::findOne(['shop_transaction_id' => $requestData['shop_transaction_id']]);

        $transaction->status = $requestData['status'];
        $transaction->save();

        $order = $transaction->order;

        Yii::$app->admin->activateOrder($order->id);


        try {
            Yii::$app->billing->newPurchase([

                'user_id' => $order->user->id,
                'user_revenue_percentage' => $order->user->revenue_percentage,
                'course_id' => $order->kurs_id,
                'order_id' => $order->id,
                'transaction_id' => $transaction->id,
                'amount' => $order->amount,
                'payment_type' => 'octo',
                'status' => Purchases::PURCHASE_ACCEPTED


            ]);

        } catch (\Exception $e) {
            file_put_contents('error.txt', $e->getMessage());
        }

        return [
            'status' => true
        ];
    }


    public function capture($data): array
    {
        $order_id = $data['shop_transaction_id'];

        $order = Order::findOne($order_id);

        if ($order_id) {
            if (!$order->isPayed) {
                Yii::$app->octo->sendCapturedRequest($data);
                return [
                    'accept_status' => 'capture'
                ];
            } else {
                return [
                    'accept_status' => 'cancel'
                ];
            }

        } else {
            return [
                'accept_status' => 'cancel'
            ];
        }


    }


    /**
     * Order muvaffaqiyatli
     * @param string $id Order id
     * @return string
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionOrderSuccess($order_id): string
    {
        $order = Order::find()->andWhere(['user_id' => user('id'), 'id' => $order_id])->one();


        if ($order == null) {
            not_found();
        }

        return $this->render('succed', [

            'order' => $order,

        ]);
    }


    public function actionTestPurchase()
    {
        Yii::$app->billing->newPurchase([

            'user_id' => user('id'),
            'user_revenue_percentage' => user('revenue_percentage'),
            'course_id' => 3,
            'order_id' => 44,
            'transaction_id' => 231,
            'amount' => 200000,
            'payment_type' => 'octo',
            'status' => Purchases::PURCHASE_ACCEPTED

        ]);
    }

}