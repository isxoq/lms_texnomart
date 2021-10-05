<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;

use common\models\User;
use Yii;
use frontend\models\PasswordResetRequestForm;
use backend\modules\profilemanager\models\ChangePasswordForm;
use yii\swiftmailer\Mailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ResetController extends FrontendController
{


    public function actionIndex()
    {
        $model = new PasswordResetRequestForm([
            'scenario' => 'phone'
        ]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->sendSmsMessage()) {

                $this->session->set('_reset_phone_number', $model->clearedPhoneNumber);
                return $this->redirect(['reset/check-code']);
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCheckCode()
    {
        $phone = $this->session->get('_reset_phone_number');

        if ($phone == null) {
            forbidden();
        }

        $model = new PasswordResetRequestForm([
            'scenario' => 'code',
            'phone' => $phone,
        ]);

        $model->normalizePhoneNumber();
        $user = $model->user;
        if ($user == null) {
            not_found();
        }

        $passwordReset = $user->password_reset_token;

        if ( empty($passwordReset)) {
            not_found();
        }

        if ($model->load($this->post())) {

            $array = $model->explodeResetToken();
            if ($array === false) {
                not_found();
            }
            $code = $array[0];
            $time = $array[1];
            if ($model->isExpired($time)) {
                forbidden(t('Verification code has been expired'));
            }

            if ($model->checkCode($code)) {

                $this->session->set('_reset_user_id', $user->id);
                return $this->redirect(['reset/set-new-password']);

            } else {
                $model->addError('code', t('Invalid verification code'));
            }

        }

        return $this->render('checkCode', [

            'model' => $model,

        ]);
    }

    public function actionSetNewPassword()
    {
        $resetUserId = $this->session->get('_reset_user_id');
        if($resetUserId == null){
            not_found();
        }
        $user = User::find()->andWhere(['id' => $resetUserId, 'status' => User::STATUS_ACTIVE])->one();
        if ($user == null){
            not_found();
        }

        $model = new ChangePasswordForm();

        if ($this->modelValidate($model)){
            $user->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $user->password_md5 = null;
            $user->generateAuthKey();
            $user->generateToken();
            if ($user->save(false)){

                Yii::$app->user->login($user);
                $this->setFlash('success', t('Your password has been changed successfully'));
                return $this->goHome();
            }
            else{
                $this->setFlash('error', t('An error occurred'));
            }
        }

        return $this->render('setNewPassword', [
            'model' => $model
        ]);
    }


    //<editor-fold desc="Mail" defaultstate="collapsed">
    /*
    public function actionIndex()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->checkLogin()) {

                if ($model->type == PasswordResetRequestForm::TYPE_EMAIL) {
                    return $this->redirect(['site/index']);
                } elseif ($model->type == PasswordResetRequestForm::TYPE_PHONE) {
                    return $this->render('resetPasswordByPhoneNumber');
                }

            }

        }
       public function actionMailer()
       {
           $mail = new PHPMailer();
           $mail->IsSMTP();
           $mail->Mailer = "smtp";
           $mail->SMTPDebug = 1;
           $mail->SMTPAuth = TRUE;
           $mail->SMTPSecure = "tls";
           $mail->Port = 587;
           $mail->Host = "smtp.gmail.com";
           $mail->Username = "virtualdars.uz@gmail.com";
           $mail->Password = 'P@$$w0rd2021';

           $mail->IsHTML(true);
           $mail->AddAddress("shukurullo0321@gmail.com", "recipient-name");
           $mail->SetFrom("virtualdars.uz@gmail.com", "from-name");
           $mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
           $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

           $mail->MsgHTML($content);
           if (!$mail->Send()) {
               dump("Error while sending Email.");
               dump($mail);
           } else {
               dump("Email sent successfully");
               die();
           }
       }

       public function actionSendEmail()
       {
           $mailer = new Mailer([

               'transport' => [
                   'class' => 'Swift_SmtpTransport',
                   'host' => 'smtp.gmail.com',
                   'encryption' => 'tsl',
                   'port' => 465,
                   'username' => 'shukurullo0321@gmail.com',
                   'password' => 'shukurulla110',


               ],
               'useFileTransport' => false,

           ]);


           $result = $mailer
               ->compose()
               ->setFrom("no-reply@virtualdars.uz")
               ->setTo('virtualdars.uz@gmail.com')
               ->setSubject('Password reset for ')
               ->send();

           dd($result);

       }

       */
    //</editor-fold>
}
