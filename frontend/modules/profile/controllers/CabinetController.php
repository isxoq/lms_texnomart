<?php

namespace frontend\modules\profile\controllers;

use soft\helpers\UploadHelper;
use Yii;
use frontend\models\SignupForm;
use soft\web\SController;
use frontend\modules\profile\models\ChangePasswordForm;
use frontend\modules\profile\models\PersonalDataForm;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;


class CabinetController extends SController
{

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => 'odilov\cropper\UploadAction',
                'url' => "/uploads/user_image",
                'path' => '@frontend/web/uploads/user_image',
                'jpegQuality' => 75,
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            \frontend\components\UserHistoryBehavior::class,
        ];
    }

    public function actionIndex()
    {
        $model = user();
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionUpdate()
    {
        $model = PersonalDataForm::createUserModel();

        $teacherInfo = user()->findOrCreateTeacherInfo();

        $upload = new UploadHelper([
            'type' => UploadHelper::TYPE_IMAGE,
            'dirName' => 'user_image',
            'required' => false,
            'fileRules' => [
                'extensions' => ['png', 'jpg', 'jpeg'],
                'maxSize' => 1024000,
            ]
        ]);

        $oldImageUrl = false;

        if ($this->modelValidate($upload) && $this->modelLoad($model)) {

            $teacherInfo->education_story = json_encode($teacherInfo->education_story);

            $fileName = $upload->upload();

            if ($fileName) {
                $oldImageUrl = $model->avatar;
                $model->avatar = $fileName;
            }

            if ($model->saveUserData()) {

                if ($oldImageUrl) {
                    $oldImage = Yii::getAlias('@frontend/web/') . $oldImageUrl;
                    if (is_file($oldImage)) {
                        unlink($oldImage);
                    }
                }

                if (user('isTeacher')) {
                    if ($this->modelValidate($teacherInfo)) {
                        $teacherInfo->education_story = Json::encode($teacherInfo->education_story);
                        $teacherInfo->experience_story = Json::encode($teacherInfo->experience_story);
                        if ($teacherInfo->save()){
                            return $this->redirect('index');
                        }
                    }
                }
                else{
                    return $this->redirect('index');
                }

            }
        }

        return $this->render('update', [
            'model' => $model,
            'upload' => $upload,
            'teacherInfo' => $teacherInfo
        ]);
    }

    public function actionUpdateTeacherInfo()
    {

        if (!user('isTeacher')) {
            not_found();
        }


    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->savePassword()) {
            $this->setFlash('success', t('Your password has been changed successfully'));
            return $this->redirect('index');
        }

        return $this->render('changePassword', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionEnterPhoneNumber()
    {
        $model = new SignupForm([
            'scenario' => 'phone'
        ]);

        if ($this->modelValidate($model)) {
            if ($model->generateCode()) {
                return $this->redirect(['verify-phone-number']);
            }
        }

        $model->captcha = null;
        return $this->render('enterPhoneNumber', [
            'model' => $model,
        ]);
    }

    /**
     * Tel. raqam to'g'ri kiritilib, sms jo'natilgandan keyin kodni tasdiqlash
     */
    public function actionVerifyPhoneNumber()
    {


        $phone = $this->session->get('_signup_phone_number', false);
        $code = $this->session->get('_signup_verification_code', false);
        if (!$phone || !$code) {
            forbidden();
        }

        $model = new SignupForm([
            'scenario' => 'verifyPhone',
        ]);

        if ($model->isVerificationCodeExpired()) {
            $this->getSession()->remove('_signup_phone_number');
            $this->getSession()->remove('_signup_verification_code');
            $this->getSession()->remove('_signup_verification_time');
            forbidden(t('Verification code has been expired'));
        }

        /**
         * Process for non-Ajax request
         **/
        if ($this->modelValidate($model)) {

            $user = user();
            $isNewPhoneNumber = empty($user->phone);
            $user->phone = Yii::$app->help->clearPhoneNumber($phone);
            $user->save(false);
            $user->sendToTelegramAboutPhoneNumber($isNewPhoneNumber);
            $this->setFlash('success', 'Telefon raqamingiz muvaffaqiyatli saqlandi!');
            return $this->redirect(['/profile/cabinet']);
        }
        return $this->render('verifyPhoneNumber', [
            'model' => $model,
        ]);
    }


}
