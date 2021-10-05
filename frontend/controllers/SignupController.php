<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;

use Yii;
use frontend\models\SignupForm;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SignupController extends FrontendController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],

        ];
    }

    /**
     * Ro'yxatdan o'tish uchun eng avval telefon raqamni tasdiqlash zarur
     */
    public function actionIndex()
    {
        $model = new SignupForm([
            'scenario' => 'phone'
        ]);

        if ($this->isAjax) {

            /**
             * Process for Ajax request
             **/

            $this->formatJson;

            if ($this->modelValidate($model)) {
                if ($model->generateCode()) {

                    $model = new SignupForm([
                        'scenario' => 'verifyPhone',
                    ]);

                    return [
                        'title' => t('Verify'),
                        'content' => $this->renderAjax('verifyModal', [
                            'model' => $model,
                        ]),
                        'footer' => Html::submitButton(t('Kiritish'), ['class' => 'btn btn-log btn-block btn-thm2']),
                    ];
                }
            }

            return [
                'title' => t('Register'),
                'content' => $this->renderAjax('indexModal', [
                    'model' => $model,
                ]),
                'footer' => Html::submitButton(t('Register'), ['class' => 'btn btn-log btn-block btn-thm2']),
            ];

        } else {
            /**
             * Process for non-Ajax request
             **/
            if ($this->modelValidate($model)) {
                if ($model->generateCode()) {
                    return $this->redirect(['signup/verify']);
                }
            }

            $model->captcha = null;
            return $this->render('index', [
                'model' => $model,
            ]);
        }


    }

    /**
     * Tel. raqam to'g'ri kiritilib, sms jo'natilgandan keyin kodni tasdiqlash
     */
    public function actionVerify()
    {

        if ($this->isAjax) {
            $this->formatJson;
        }
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


        if ($this->isAjax) {
            /**
             * Process for Ajax request
             **/
            if ($this->modelValidate($model)) {

                $this->session->set('_phone_number_is_verified', true);
                $phone = $this->session->get('_signup_phone_number', false);
                $model = new SignupForm([
                    'scenario' => 'register',
                    'phone' => $phone,
                ]);

                return [
                    'title' => t('Register'),
                    'content' => $this->renderAjax('registerModal', [
                        'model' => $model,
                    ]),
                    'footer' => Html::submitButton(t('Register'), ['class' => 'btn btn-log btn-block btn-thm2']),
                ];

            } else {
                return [
                    'title' => t('Verify'),
                    'content' => $this->renderAjax('verifyModal', [
                        'model' => $model,
                    ]),
                    'footer' => Html::submitButton(t('Kiritish'), ['class' => 'btn btn-log btn-block btn-thm2']),
                ];
            }

        } else {
            /**
             * Process for non-Ajax request
             **/
            if ($this->modelValidate($model)) {
                $this->session->set('_phone_number_is_verified', true);
                return $this->redirect(['signup/register']);
            }
            return $this->render('verify', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegister()
    {
        $phone = $this->session->get('_signup_phone_number', false);
        $isVerified = $this->session->get('_phone_number_is_verified', false);

        if ($this->isAjax) {
            $this->formatJson;
        }

        if (!$phone || !$isVerified) {
            forbidden();
        }

        $model = new SignupForm([
            'scenario' => 'register',
            'phone' => $phone,
        ]);

        if ($this->isAjax) {

            $this->formatJson;

            /**
             * Process for Ajax request
             **/

            if ($this->modelValidate($model) && $model->signup()) {
                $this->setFlash('success', settings('signup', 'success_message'));
                return [
                    'redirect' => to(['site/index'])
                ];
            } else {

                return [
                    'title' => t('Register'),
                    'content' => $this->renderAjax('registerModal', [
                        'model' => $model,
                    ]),
                    'footer' => Html::submitButton(t('Register'), ['class' => 'btn btn-log btn-block btn-thm2']),
                ];

            }


        } else {

            /**
             * Process for non-Ajax request
             **/

            if ($this->modelValidate($model) && $model->signup()) {
                $this->setFlash('success', settings('signup', 'success_message'));
                return $this->redirect(['site/index']);
            }

            return $this->render('register', [
                'model' => $model,
            ]);

        }

    }

}