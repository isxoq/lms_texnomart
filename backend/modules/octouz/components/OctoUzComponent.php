<?php

namespace backend\modules\octouz\components;

use backend\modules\octouz\models\Octouz;
use backend\modules\octouz\models\OctouzTransactions;
use backend\modules\ordermanager\models\Order;
use yii\base\Component;
use yii;

class OctoUzComponent extends Component
{
    const OCTO_REQUEST_URL = 'https://secure.octo.uz/prepare_payment';
    const OCTO_SET_ACCEPT_URL = 'https://secure.octo.uz/set_accept';


    public $shop_id;
    public $secret;
    public $octo;

    public function init()
    {
        $this->octo = Octouz::find()->one();
        $this->shop_id = $this->octo->shop_id;
        $this->secret = $this->octo->secret;
    }

    public function sendCapturedRequest($data)
    {
        $requestData = [
            'octo_shop_id' => $this->shop_id,
            'octo_secret' => $this->secret,
            'octo_payment_UUID' => $data['octo_payment_UUID'],
            'accept_status' => "capture",
        ];


        $jsonData = json_encode($requestData);

        $ch = curl_init(self::OCTO_SET_ACCEPT_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData),
        ));

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        file_put_contents('dsd.txt', $jsonData);
        file_put_contents('b.txt', $result);

    }

    public function generate_form($order_id)
    {
        // get order by id
        $order = Order::findOne($order_id);

        if (!$order) {
            return Yii::t('app', 'Order Not Found!');
        }

        // get total payment amount in base currency
        $amount = $order->amount;
        $currency = $this->octo->currency;
        $description = Yii::t('app', 'Order #{number}', [
            'number' => $order_id
        ]);
        $creationTimestamp = $order->created_at;

        $requestData = [
            'test' => (bool)$this->octo->test,
            'octo_shop_id' => $this->shop_id,
            'octo_secret' => $this->secret,
            'shop_transaction_id' => $order_id,
            'auto_capture' => (bool)$this->octo->auto_capture,
            'init_time' => date('Y-m-d H:i:s', $creationTimestamp),
            'total_sum' => $amount,
//            'user_data' => [
//                'user_id' => Yii::$app->user->identity->id,
//                'phone' => Yii::$app->user->identity->phone,
//                'email' => Yii::$app->user->identity->email
//            ],
            'currency' => $this->octo->currency,
            //            "payment_methods" => [
            //                [
            //                    "method" => "uzcard"
            //                ],
            //                [
            //                    "method" => "humo"
            //                ],
            //                [
            //                    "method" => "bank_card"
            //                ]
            //            ],
            'language' => Yii::$app->language,
            'description' => $description,
            'return_url' => $this->octo->return_url . $order_id
            //"return_url" => $order->get_checkout_order_received_url()
        ];


        $jsonData = json_encode($requestData);
//        dd($jsonData);

        $ch = curl_init(self::OCTO_REQUEST_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData),
        ));

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


//        dd($result);

        if ($httpcode === 200) {


            $transaction = new OctouzTransactions();

            $data = json_decode($result, true);

            $transaction->error = $data['error'];
            $transaction->status = $data['status'];
            $transaction->shop_transaction_id = $data['shop_transaction_id'];
            $transaction->octo_payment_UUID = $data['octo_payment_UUID'];
            $transaction->octo_pay_url = $data['octo_pay_url'];
            $transaction->errorMessage = $data['errorMessage'] ?? null;
            $transaction->transfer_sum = $data['transfer_sum'] ?? null;
            $transaction->refunded_sum = $data['refunded_sum'] ?? null;

            $transaction->save();


            if ($data['error'] !== 0) {
                return '<p>OCTO.uz ERROR: ' . $data['errorMessage'] . '</p>';
            }

            $label_pay = Yii::t('app', 'Pay with OCTOUZ');
            $label_cancel = Yii::t('app', 'Cancel Payment');

            $form = <<<HTML
<a class="btn_1 full-width " href="{$data['octo_pay_url']}">$label_pay</a>
HTML;

            return $form;
        }

        return Yii::t('app', 'OCTO.uz: ERROR GENERATING ORDER');
    }


}


?>