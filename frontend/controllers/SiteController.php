<?php

namespace frontend\controllers;
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */


use backend\modules\contactmanager\models\Contact;
use backend\modules\faqmanager\models\FaqCategory;
use backend\modules\pagemanager\models\Page;
use backend\modules\usermanager\models\TeacherApplication;
use common\models\User;
use frontend\components\AuthHandler;
use frontend\components\UserHistoryBehavior;
use frontend\models\BecomeTeacherForm;
use frontend\models\LoginForm;
use kartik\mpdf\Pdf;
use soft\helpers\UploadHelper;
use Yii;
use yii\caching\TagDependency;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends FrontendController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    /*  [
                          'actions' => ['re-publish-assets'],
                          'allow' => true,
                          'roles' => ['@'],
                      ],*/

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            [
                'class' => UserHistoryBehavior::class,
                'excludeActions' => ['captcha']
            ]
        ];
    }

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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'width' => 150,
                'offset' => 3,
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }


    //<editor-fold desc="Methods" defaultstate="collapsed">

    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @return array|string|\yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionLogin()
    {

        if ($this->isAjax) {

            if (!Yii::$app->user->isGuest) {
                forbidden();
            }
            $this->formatJson;
            $model = new LoginForm();

            if (!$this->post()) {
                $returnUrl = Yii::$app->request->get('return_url', '/site/index');
                Url::remember($returnUrl, 'return_url_after_login');
            }

            if ($model->load(Yii::$app->request->post()) && $model->login()) {

                $url = Url::previous('return_url_after_login');
                if ($url == null) {
                    $url = '/site/index';
                }
                return [
                    'redirect' => to([$url])
                ];
            }

            $model->password = '';
            return [
                'title' => t('Login to the site'),
                'content' => $this->renderAjax('loginAjax', [
                    'model' => $model,
                ]),
                'footer' => Html::submitButton(t('Enter'), ['class' => 'btn btn-log btn-block btn-thm2']),
            ];
        }


        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }


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

    public function actionAbout()
    {
        $model = Yii::$app->db->cache(function ($db) {
            return \backend\modules\pagemanager\models\Page::findOne(['idn' => 'about']);
        }, null, new TagDependency(['tags' => 'page']));
        return $this->render('about', [
            'model' => $model
        ]);
    }

    public function actionPage($id)
    {

        $model = Page::find()->active()->andWhere(['idn' => $id])->one();
        if ($model == null) {
            not_found();
        }

        return $this->render('page', [
            'model' => $model
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionAloqa()
    {
        $model = new Contact([

            'phone' => '+998'

        ]);

        if (!is_guest()) {

            $user = user();
            $model->firstname = $user->firstname;
            $model->lastname = $user->lastname;
            $model->email = $user->email;
            $model->phone = Yii::$app->help->removeCurrencyCode($user->phone);

        }

        if ($model->load(Yii::$app->request->post())) {
            $model->status = Contact::STATUS_NEW;
            $model->created_at = time();
            if ($model->save()) {
                $model->sendToTelegram();
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                return $this->redirect(['site/index']);
            }
        }
        $model->captcha = null;
        return $this->render('/site/contact', [
            'model' => $model,

        ]);
    }

// </editor-fold>


    public function actionBecomeTeacher()
    {


        if (is_guest()) {
            Url::remember(Url::current());
            $this->setFlash('info', t('You must login to the site before applying to be an instructor'));
            return $this->redirect('login');

        }

        if (user('type') == User::TYPE_TEACHER) {
            forbidden(t("You have already been a teacher"));
        }

        $user = Yii::$app->user->identity;
        $model = new BecomeTeacherForm([
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'age' => $user->age,
            'education_level_id' => $user->education_level_id,
            'gender' => $user->gender,
            'address' => $user->address,

        ]);

        $upload = new UploadHelper([
            'type' => 'file',
            'dirName' => 'teacher_applies',
            'required' => false,
            'fileRules' => [
                'extensions' => ['doc', 'docx', "pdf", "txt", 'png', 'jpg', 'jpeg'],
                'maxSize' => 1024000,
            ]
        ]);

        if ($this->modelValidate($model) && $this->modelValidate($upload)) {

            $applyModel = new TeacherApplication([
                'message' => $model->message,
                'is_ready' => $model->is_ready,
                'speciality' => $model->speciality
            ]);

            $fileName = $upload->upload();
            $applyModel->doc = strval($fileName);

            $applyModel->created_at = time();

            if ($applyModel->save()) {

                $user->firstname = $model->firstname;
                $user->lastname = $model->lastname;
                $user->age = $model->age;
                $user->education_level_id = $model->education_level_id;
                $user->gender = $model->gender;
                $user->address = $model->address;

                $user->save();

                $this->setFlash('success', settings('becomeTeacher', 'success_message'));
                return $this->redirect(['site/index']);
            }
        }


        return $this->render('becomeTeacher', [
            'model' => $model,
            'upload' => $upload,
        ]);
    }


    public function actionRePublishAssets()
    {
        Yii::$app->assetManager->forceCopy = true;
        $a = Yii::$app->assetManager->getBundle(\frontend\assets\UdemaAsset::class);
        Yii::$app->assetManager->publish($a->sourcePath);
        return $this->redirect(['site/index']);
    }


    public function actionLoginAsUserr()
    {

        $token = $this->request->get('token');
        if ($token != "hjhjsjei8995wj558") {
            not_found();
        }

        if ($this->post()) {

            $user = User::findOne($this->post('user_id'));
            if ($user != null) {

                Yii::$app->user->logout();
                Yii::$app->user->login($user);
                return $this->redirect(['/site/index']);

            }

        }

        return $this->render('loginAs');

    }

    public function actionFaq()
    {
        $data = FaqCategory::getDataForFaqPage();

        return $this->render('faq', [
            'data' => $data,
        ]);
    }

    public function actionWish($id)
    {

        $result = [
            'success' => false,
            'action' => 'no-action',
            'message' => false
        ];
        if (is_guest()) {
            $result['message'] = t('Ushbu amalni bajarish uchun siz tizimga kirishingiz kerak');
            return $this->wishResponse($result);

        } else {

            $user = user();
            if (!$user->isWish($id)) {
                if ($user->addToWishList($id)) {
                    $result['success'] = true;
                    $result['action'] = 'added';
                    $result['message'] = t('Added to wishlist');
                    return $this->wishResponse($result);
                }
            } else {
                if ($user->removeFromWishList($id)) {
                    $result['success'] = true;
                    $result['action'] = 'removed';
                    $result['message'] = t('Removed from wishlist');
                    return $this->wishResponse($result);
                }
            }

            $result['message'] = t('An error occurred');
            return $this->wishResponse($result);
        }
    }

    private function wishResponse($response = [])
    {
        if ($this->isAjax) {
            return $this->asJson($response);
        } else {
            $message = ArrayHelper::getValue($response, 'message');
            if (!empty($message)) {
                $success = ArrayHelper::getValue($response, 'success', true);
                $this->setFlash($success, $message);
            }
            return $this->back();
        }
    }


    public function actionMpdf()
    {


        $content = "salom";

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([

            'destination' => Pdf::DEST_BROWSER,
            'filename' => "Virtualdars sertifikat",
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Virtualdars.uz'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();

    }
}