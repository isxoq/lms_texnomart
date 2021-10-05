<?php


namespace backend\modules\smsmanager\models;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotAcceptableHttpException;

/**
 *
 * @property-read mixed $password
 * @property-read false $newToken
 * @property-read mixed $email
 * @property-read false $token
 */
class Sms extends \yii\base\Component
{

    public $tokenExpiredDays = 29;

    public function getEmail()
    {
        $email = SmsSettings::findOne(['idn' => 'email']);
        return $email->value;
    }

    public function getPassword()
    {
        $password = SmsSettings::findOne(['idn' => 'password']);
        return $password->value;
    }
/*
    private function tokenIsExpired()
    {

    }*/

    public function getNewToken()
    {
        $email = $this->email;
        $password = $this->password;
        if ($email=='' || $password == ''){
            return false;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "notify.eskiz.uz/api/auth/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('email' => $email,'password' => $password),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $result = Json::decode($response);
        if ($result['message'] == 'token_generated'){
            return $result['data']['token'];
        }
        else{
            return false;
        }
    }

    public function updateToken()
    {

        $newToken = Yii::$app->sms->getNewToken();
        if (!$newToken){
            return false;
        }

        $model = SmsSettings::findOne(['idn' => 'token']);
        if ($model == null){
            $model = new SmsSettings([
                'idn' => 'token',
                'name' => 'Token'
            ]);
        }

        $model->value = $newToken;
        if ($model->save()){
            return $newToken;
        }
        else{
            return false;
        }
    }

    public function getToken()
    {
        $model = SmsSettings::findOne(['idn' => 'token']);
        if ($model == null){
            $model = new SmsSettings([
                'idn' => 'token',
                'name' => 'Token',
                'value' => $this->getNewToken(),
            ]);
            $model->save();
        }
        else{
            if (  $model->value == '' || time() >=  $model->updated_at + $this->tokenExpiredDays * 86400 ){
                return $this->updateToken();
            }
            else{
                return $model->value;
            }

        }
    }

    public function getAllMessages($year=null, $month=null)
    {
        if ($year == null){
            $year = date('Y');
        }
        if ($month == null){
            $month = date('m');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "notify.eskiz.uz/api/message/sms/get-user-messages",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('year' => $year,'month' => $month),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$this->token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return Json::decode($response);
    }
    /**
     *
     * @error response:  "{"status":"error","message":{"mobile_phone":["The mobile phone format is invalid."]}}"
     **/

    public function sendMessage($phoneNumber, $message)
    {

        $phoneNumber = str_replace( '+', "", $phoneNumber);

        if (strlen($phoneNumber) == 9){
            $phoneNumber = "998".$phoneNumber;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "notify.eskiz.uz/api/message/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'mobile_phone' => $phoneNumber,
                'message' => $message,
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$this->token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if(!$response){
            return false;
        }
        $result = Json::decode($response);
        if ($result['status'] === 'error' ){
            return false;
        }
        else{
            return true;
        }

    }

    public function sendVerificationCode($phoneNumber, $code)
    {
//        $host = Yii::$app->request->hostInfo;
        $host = Yii::$app->name;
        $message  = $host ."\n".t('Verification code')."\n".$code;
        return $this->sendMessage($phoneNumber, $message);
    }


     public function sendResetCode($phoneNumber, $code)
    {
//        $host = Yii::$app->request->hostInfo;
        $host = Yii::$app->name;
        $message  = $host ."\n".t('Code to reset pasword')."\n".$code;
        return $this->sendMessage($phoneNumber, $message);
    }


    
}