<?php


namespace frontend\modules\mbapp\controllers;

use Yii;
use backend\modules\profilemanager\models\ChangePasswordForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;

class ResetController extends DefaultController
{

    public $loginRequired = false;

    public function actionIndex()
    {

        $phone = $this->post('phone');
        if ($phone == null) {
            return $this->error();
        }

        $model = new PasswordResetRequestForm([
            'phone' => $phone
        ]);
        $model->normalizePhoneNumber();
        $user = $model->user;
        if ($user == null) {
            return $this->userNotFoundError();
        }
        $clearedPhoneNumber = $model->clearedPhoneNumber;
        $code = mt_rand(11111, 99999);
        $time = time() + PasswordResetRequestForm::EXPIRED_SECONDS;
        $user->password_reset_token = $code . "_" . $time;

        if ($user->save(false)) {
            if (Yii::$app->sms->sendResetCode($clearedPhoneNumber, $code)){
                return $this->success();
            }
            else{
                return $this->error(t('An error occured while sending verification code to your phone number'));
            }
        }
        else{
            return $this->error("Foydalanuvchi ma'lumotini saqlashda xatolik yuz berdi");
        }

    }

    public function actionCheckCode()
    {
        $phone = $this->post('phone');

        if ($phone == null) {
            return $this->error('Telefon raqamni kiriting');
        }

        $model = new PasswordResetRequestForm([
            'phone' => $phone,
        ]);

        $model->normalizePhoneNumber();
        $user = $model->user;
        if ($user == null) {
            return $this->userNotFoundError();
        }
        $passwordReset = $user->password_reset_token;

        if (empty($passwordReset)) {
            return $this->error('Empty reset token');
        }

        $code = $this->post('code');
        $model->code = $code;


        $array = $model->explodeResetToken();
        if ($array === false) {
            return $this->error('Invalid reset token');
        }

        $validCode = $array[0];
        $time = $array[1];
        if ($model->isExpired($time)) {
            return $this->error(t('Verification code has been expired'));
        }
        if ($model->checkCode($validCode)) {

            $password = $this->post('password');
            if (strlen($password) < 5){
                return $this->error("Parol kamida 5 ta belgidan iborat bo'lishi kerak");
            }
            else{

                $user->password_hash = Yii::$app->security->generatePasswordHash($password);
                $user->password_md5 = null;
                $user->generateAuthKey();
                $user->generateToken();
                if ($user->save(false)){
                    return $this->success($user);

                }
                else{
                    $this->error( t('An error occurred'));
                }

            }

        } else {
            return $this->error( t('Invalid verification code'));
        }

        return $this->error();

    }


}