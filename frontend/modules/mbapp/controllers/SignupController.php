<?php

namespace frontend\modules\mbapp\controllers;

use Yii;
use frontend\modules\mbapp\models\TempNumber;

class SignupController extends DefaultController
{

    /**
     * @return array
     */
    public function actionRegister()
    {
        TempNumber::clearExpired();
        $phoneNumber = Yii::$app->help->clearPhoneNumber($this->post('phone_number'));
        $model = TempNumber::findOne(['phone_number' => $phoneNumber]);
        if ($model == null) {
            $model = new TempNumber([
                'phone_number' => $phoneNumber
            ]);
        }
        $model->firstname = $this->post('firstname');
        $model->lastname = $this->post('lastname');
        $model->password = $this->post('password');
        $model->expired_at = time() + TempNumber::AVAILABLE_SECONDS;

        if ($model->validate()) {

            if ($model->isNewRecord) {
                $model->generateCode();
            }
            if ($model->save(false)) {
                return [
                  'success' => true,
                  'message' => t('Enter the code sent to your phone number'),
                ];
            }
            return $this->error($model->error);
        }

        return $this->error(($model->error));

    }


    public function actionVerify()
    {
        TempNumber::clearExpired();
        $phoneNumber = Yii::$app->help->clearPhoneNumber($this->post('phone_number'));
        $model = TempNumber::findOne(['phone_number' => $phoneNumber]);
        if ($model == null){
            return $this->error(t('Page not found!'));
        }

        $code = $this->post('code');
        if ($model->code != $code){
            return $this->error(t('Incorrect verification code. Repeat again.'));
        }
        else{

            $result = $model->signup();

            if ($result === false){
                return $this->error(t('An error occurred'));
            }
            else{
                $model->delete();
                return $this->success($result, t('Congratulations. You have successfully registered'));
            }

        }

    }

    protected function verbs()
    {
        return [
            'register' => ['POST'],
            'verify' => ['POST'],
        ];
    }

}