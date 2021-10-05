<?php

namespace backend\modules\usermanager\controllers;

use backend\controllers\BackendController;
use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\Kurs;
use Yii;
use backend\modules\usermanager\models\User;
use backend\modules\usermanager\models\search\UserSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Class UserController
 * @package backend\modules\usermanager\controllers
 */
class UserController extends BackendController
{


    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'bulk-delete' => ['POST'],
                    'change-status' => ['POST'],
                    'change-type' => ['POST'],
                ],
            ],
        ];
    }

    //<editor-fold desc="CRUD" defaulstate=collapsed>
    public function actionIndex()
    {

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => User::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User([
            'revenue_percentage' => 70
        ]);
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = User::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = User::findModel($id);
        $courses = $model->courses;

        if (!empty($courses)) {

            $message = "Sizga ushbu foydalanuvchini o'chirishga ruxsat berilmaydi!\n
                Sababi ushbu foydalanuvchiga tegishli " . count($courses) . ' ta kurs bor!
            ';

            forbidden($message);

        }

        $model->delete();
        if ($this->isAjax) {
            $this->formatJson;
            return ['forceReload' => '#crud-datatable-pjax', 'forceClose' => true];
        }
        return $this->redirect(['index']);
    }

    //</editor-fold>

    /**
     * Add new enrollment
     * @param $id
     * @return string|\yii\web\Response
     * @throws Yii\web\NotFoundHttpException
     */
    public function actionEnroll($id)
    {
        $model = User::findModel($id);

        $enroll = new Enroll([
            'user_id' => $model->id,
        ]);

        if ($enroll->loadPost()) {
            return $this->redirect(['user/create-enroll', 'user_id' => $enroll->user_id, 'kurs_id' => $enroll->kurs_id]);
        }


        return $this->render('enroll', [
            'model' => $model,
            'enroll' => $enroll,
        ]);
    }

    public function actionCreateEnroll($user_id, $kurs_id)
    {
        $user = User::findModel($user_id);
        $kurs = Kurs::findModel($kurs_id);
        $enroll = Enroll::findOrCreateModel($user_id, $kurs_id);

        $enroll->type = $kurs->is_free ? Enroll::TYPE_FREE : Enroll::TYPE_PURCHASED;
        $enroll->generateEndTime($kurs->duration);

        $enroll->sold_price = $kurs->is_free ? 0 : $kurs->price;

        if ($enroll->loadPost()) {
            $enroll->end_at = strtotime($enroll->end_at);
            if ($enroll->save()) {

                $this->setFlash('success', "Foydalanuvchi kursga a'zo qilindi!!!");
                return $this->redirect(['user/index']);

            }
        }

        $enroll->end_at = date('Y-m-d', $enroll->end_at);

        return $this->render('createEnroll', [

            'user' => $user,
            'kurs' => $kurs,
            'enroll' => $enroll

        ]);
    }


    public function actionChangeStatus($id = '')
    {
        /** @var User $model */
        $model = User::findModel($id);
        $model->status = $model->status == User::STATUS_ACTIVE ? User::STATUS_INACTIVE : User::STATUS_ACTIVE;
        $model->save(false);

        if ($this->isAjax) {

            $this->formatJson;
            return ['forceReload' => '#crud-datatable-pjax', 'forceClose' => true];
        } else {
            return $this->back();
        }

    }

    public function actionChangeType($id = '')
    {
        /** @var User $model */
        $model = User::findModel($id);
        $model->type = $model->isTeacher ? User::TYPE_USER : User::TYPE_TEACHER;
        $model->save(false);
        if ($this->isAjax) {
            $this->formatJson;
            return ['forceReload' => '#crud-datatable-pjax', 'forceClose' => true];
        } else {
            return $this->back();
        }

    }


    public function actionGenerateAuthKey()
    {
        $users = User::getAll();
        foreach ($users as $user) {
            $user->generateToken();
            $user->save(false);
        }
    }


    public function actionEnrolls($id)
    {
        $model = User::findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getEnrolls()->with('kurs'),
        ]);
        return $this->render('enrollsList', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCourses($id)
    {
        $model = User::findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getCourses(),
        ]);
        return $this->render('coursesList', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

}
