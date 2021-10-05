<?php

namespace frontend\controllers;
/**
 * Created by Isxoqjon Axmedov.
 * WEB site: https://www.ninja.uz
 * Date: 5/12/2021
 * Time: 9:29 AM
 * Project name: virtualdars
 */

use backend\modules\faqmanager\models\FaqCategory;
use common\models\User;
use frontend\components\AuthHandler;
use frontend\components\UserHistoryBehavior;
use kartik\mpdf\Pdf;
use Yii;
use backend\modules\usermanager\models\TeacherApplication;
use backend\modules\contactmanager\models\Contact;
use backend\modules\pagemanager\models\Page;
use frontend\models\BecomeTeacherForm;
use frontend\models\LoginForm;
use soft\helpers\UploadHelper;
use yii\caching\TagDependency;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Auth controller
 */
class AuthController extends FrontendController
{

    public $enableCsrfValidation = false;


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        dd($client);
        exit();
        (new AuthHandler($client))->handle();
    }

    public function actionLogin()
    {

        if ($this->isAjax) {

            if (!Yii::$app->user->isGuest) {
                forbidden();
            }
            $this->formatJson;
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return [
                    'redirect' => to(['site/index'])
                ];
            }

            $model->password = '';
            return [
                'title' => t('Login to the site'),
                'content' => $this->renderAjax('loginAjax', [
                    'model' => $model,
                ]),
                'footer' => Html::submitButton(t('Enter'), ['class' => 'btn_1 rounded']),
            ];
        }


        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'login_layout';

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/index']);
    }


}

