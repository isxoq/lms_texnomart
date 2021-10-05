<?php

namespace frontend\modules\teacher\controllers;

use backend\modules\billing\models\OfflinePayments;
use backend\modules\billing\models\Purchases;
use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\search\KursCommentSearch;
use backend\modules\usermanager\models\User;
use frontend\components\UserHistoryBehavior;
use Yii;
use frontend\modules\teacher\models\search\SectionSearch;
use frontend\modules\teacher\models\Section;
use soft\widget\SDFormWidget;
use soft\web\SController;
use frontend\modules\teacher\models\Kurs;
use frontend\modules\teacher\models\search\KursSearch;
use frontend\modules\teacher\models\search\EnrollSearch;
use yii\base\BaseObject;
use yii\filters\VerbFilter;

class KursController extends SController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'change-status' => ['post'],
                ],
            ],

            UserHistoryBehavior::class,

        ];
    }

    public function actions()
    {
        return [
            'uploadimage' => [
                'class' => 'odilov\cropper\UploadAction',
                'url' => '/uploads/course',
                'path' => '@frontend/web/uploads/course',
                'jpegQuality' => 75,
            ]
        ];
    }

    public function actionIndex()
    {

        $searchModel = new KursSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index_gridview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Kurs::findOwnModel($id),
        ]);
    }

    public function actionSections($id)
    {
        $model = Kurs::findOwnModel($id);
        $searchModel = new SectionSearch([
            'kurs_id' => $id,
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('sections', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionStudents($id)
    {
        $model = Kurs::findOwnModel($id);

        $searchModel = new EnrollSearch();
        $searchModel->kurs_id = $id;
        $query = $model->getEnrolls()->joinWith('user')->latest();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);

        return $this->render('students', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionComments($id)
    {
        $model = Kurs::findOwnModel($id);

        $searchModel = new KursCommentSearch();
        $searchModel->kurs_id = $id;
        $query = $model->getActiveComments()->joinWith('user')->latest();
        $dataProvider = $searchModel->search($query);

        return $this->render('comments', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new Kurs([
            'scenario' => 'teacher-form',
            'duration' => '+1 year',
        ]);
        if ($model->loadPost()) {
            $model->status = Kurs::STATUS_WAITING;
            $model->prepareToSave();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Kurs::findOwnModel($id);
        $model->scenario = 'teacher-form';
        if ($model->loadPost()) {
            $model->prepareToSave();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id = '')
    {

        $this->setJsonResponse();

        $model = Kurs::findOwnModel($id);

        if (YII_ENV_PROD && $model->isConfirmed) {
            if ($model->hasActiveEnrolls) {
                forbidden("Diqqat!!! Ushbu kursga a'zo bo'lgan va hozirda a'zolik muddati tugamagan o'quvchilar bor! <br> Shu tufayli sizga ushbu bo'limni o'chirishga ruxsat berilmaydi");
            }
        }

        /**
         * @see Kurs::beforeDelete()
         **/
        $model->delete();
        if ($this->isAjax) {
            return ['forceReload' => '#crud-datatable-pjax', 'forceClose' => true];
        }
        return $this->redirect('index');
    }

    public function actionEditSections($id = '')
    {
        $model = Kurs::findOwnModel($id);
        $sections = $model->sections;
        $dform = new SDFormWidget([
            'models' => $sections,
            'modelsScenario' => 'teacher-form',
            'modelsAttributes' => ['kurs_id' => $model->id],
            'modelClass' => Section::class,
            'sortAttribute' => 'sort',
        ]);

        if ($dform->save()) {
            return $this->redirect(['/teacher/kurs/sections', 'id' => $id]);
        }

        return $this->render('editSections', [
            'model' => $model,
            'sections' => (empty($sections)) ? [new Section()] : $sections
        ]);
    }

    public function actionChangeStatus($id)
    {
        $model = Kurs::findOwnModel($id);
        if (!$model->isConfirmed) {
            forbidden();
        }
        $model->changeStatus();

        if ($this->isAjax) {
            $this->formatJson;
            return ['forceReload' => '#crud-datatable-pjax', 'forceClose' => true];
        } else {
            return $this->redirect(['index']);
        }

    }

    /**
     * Teacher tomonidan talabani o'zining kursiga a'zo qilish uchun userni tanlash
     */
    public function actionSelectUser($id = '')
    {
        $model = Kurs::findOwnModel($id);


        if ($this->post()) {

            $data = $this->post('user');

            if (empty($data)) {

                $this->setFlash('error', "Foydalanuvchi ma'lumotini kiriting");
            }

            $user = User::findOne(['phone' => $data]);

            if ($user == null) {
                $user = User::findOne(['email' => $data]);
            }

            if ($user == null) {
                $this->setFlash('error', 'Foydalanuvchi topilmadi');
            } else {

                $this->session->set('enroll_user_id', $user->id);
                return $this->redirect(['create-enroll', 'id' => $model->id]);
            }
        }
        return $this->render('selectUser', ['model' => $model]);
    }

    /**
     * O'qituvchi tomonidan yangi user qo'shish
     * @param string $id Kurs id raqami
     * @return string|\yii\web\Response
     * @throws \Yii\web\ForbiddenHttpException
     * @throws \Yii\web\NotFoundHttpException
     */
    public function actionAddUser($id = '')
    {
        $model = Kurs::findOwnModel($id);
        $user = new User();
        $user->scenario = 'create-by-teacher';

        if ($user->loadPost()) {

            $phone = Yii::$app->help->clearPhoneNumber($user->phone);

            if (strlen($phone) == 9) {
                $phone = '998' . $phone;
            }

            $user->phone = $phone;

            if ($user->validate()) {

                $user->revenue_percentage = 70;
                $user->status = User::STATUS_ACTIVE;
                $user->type = User::TYPE_USER;

                // 'password_hash', 'auth_key', 'token' parameters are generated automatically before validate
                // @see [[User::beforeValidate()]]

                if ($user->save()) {
                    $user->sendToTelegramAboutNewUserByTeacher($user, user());
                    $this->session->set('enroll_user_id', $user->id);
                    return $this->redirect(['create-enroll', 'id' => $model->id]);
                }
            }
        }

        return $this->render('addUser', [
            'model' => $model,
            'user' => $user,
        ]);

    }


    /**
     * @param string $id Kurs id
     */
    public function actionCreateEnroll($id = '')
    {
        $user_id = $this->session->get('enroll_user_id');
        if ($user_id == null) {
            return $this->redirect(['kurs/select-user', 'id' => $id]);
        }
        $kurs = Kurs::findOwnModel($id);
        $user = User::findModel($user_id);

        $enroll = Enroll::findOrCreateModel($user_id, $id);

        $enroll->type = $kurs->is_free ? Enroll::TYPE_FREE : Enroll::TYPE_PURCHASED;
        $enroll->generateEndTime($kurs->duration);

        $enroll->sold_price = $kurs->is_free ? 0 : $kurs->price;

        if ($this->post()) {

            $enroll->created_by = Yii::$app->user->identity->id;
            if ($enroll->save()) {

                /** @var \common\models\User $teacher */
                $teacher = Yii::$app->user->identity;
                $teacher->sendToTelegramAboutNewEnrollmentByTeacher($user, $enroll, $teacher, $kurs);
                $this->savePaymentInfo($user, $kurs, $enroll);
                $this->setFlash('success', "Foydalanuvchi kursga a'zo qilindi!!!");
                $this->session->remove('enroll_user_id');
                return $this->redirect(['students', 'id' => $kurs->id]);

            }
        }

        return $this->render('createEnroll', [

            'user' => $user,
            'kurs' => $kurs,
            'enroll' => $enroll

        ]);

    }

    /**
     * @param $user User
     * @param $kurs Kurs
     * @param $enroll Enroll
     * @return bool
     */
    private function savePaymentInfo($user, $kurs, $enroll)
    {

        $model = new OfflinePayments();
        $model->user_id = $user->id;
        $model->course_id = $kurs->id;
        $model->created_at = time();
        $model->updated_at = time();
        $model->status = OfflinePayments::ACCEPTED;
        $model->amount = $enroll->sold_price;
        $model->type = 'plastik';


        if ($model->save()) {

            Yii::$app->billing->newPurchase([

                'user_id' => $model->user_id,
                'user_revenue_percentage' => $model->user->revenue_percentage,
                'course_id' => $model->course_id,
                'order_id' => null,
                'transaction_id' => $model->id,
                'amount' => $model->amount,
                'payment_type' => 'offline_payment',
                'status' => Purchases::PURCHASE_ACCEPTED

            ]);

            return true;
        } else {

            return false;
        }

    }


}
