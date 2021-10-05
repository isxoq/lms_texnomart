<?php


namespace frontend\modules\mbapp\controllers;

use frontend\models\LoginForm;


class AuthController extends DefaultController
{

    public $loginRequired = false;

    public function actionLogin()
    {

        $username = $this->post('username');
        $password = $this->post('password');

        $model = new LoginForm([
            'username' => $username,
            'password' => $password,
        ]);

        if ($model->validate()){
            $user = $model->user;
            $user->generateAuthKey();
            $user->generateToken();
            $user->save(false);
            return $this->success($user);
        }
        else{
            return $this->error($model->errorMessage);
        }

    }

}
