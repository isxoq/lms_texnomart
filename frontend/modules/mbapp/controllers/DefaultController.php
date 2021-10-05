<?php

namespace frontend\modules\mbapp\controllers;

use common\models\User;
use frontend\models\LoginForm;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{

    public $loginRequired = true;
    public $enableCsrfValidation = false;

    public function init()
    {

        Yii::$app->response->format = 'json';

        if ($this->loginRequired)
        {
            $this->loginUser();
        }

        parent::init();
    }

    public function loginUser()
    {
        $token = Yii::$app->request->getHeaders()->get('token');
        if ($token != null) {
            $user = User::findOne(['token' => $token, 'status' => User::STATUS_ACTIVE]);
            if ($user !== null) {

                Yii::$app->user->login($user);
            }
        }
    }

     /**
     * @return yii\console\Request|yii\web\Request
     */
    public function request()
    {
        return Yii::$app->request;
    }

    /**
     * @param null $name
     * @param null $defaultValue
     * @return array|mixed
     */
    public function post($name = null, $defaultValue = null)
    {
        return $this->request->post($name, $defaultValue);
    }

    /**
     * @param mixed $data
     * @param string $message
     * @return array
     */
    public function success($data=null, $message = 'success')
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * @param null|string $message
     * @return array
     */
    public function error($message = null)
    {
        if ($message == null) {
            $message = "Xatolik yuz berdi!";
        }
        return [
            'success' => false,
            'message' => $message,
        ];
    }

    public function userNotFoundError()
    {
        return $this->error("Foydalanuvchi topilmadi!");
    }

}
