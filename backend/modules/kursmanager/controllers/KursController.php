<?php

namespace backend\modules\kursmanager\controllers;

use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\search\EnrollSearch;
use Yii;
use soft\web\SController;
use soft\widget\SDFormWidget;
use yii\data\ActiveDataProvider;
use backend\modules\kursmanager\models\Section;
use backend\modules\kursmanager\models\Kurs;
use backend\modules\kursmanager\models\search\KursSearch;
use backend\modules\kursmanager\models\search\SectionSearch;
use yii\filters\VerbFilter;

class KursController extends SController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
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
                    'delete' => ['post'],
                    'delete-enroll' => ['post'],
                    'change-status' => ['post'],
                    'approve-or-disapprove' => ['post'],
                ],
            ],

        ];
    }


    public function actions()
    {
        return [
            'uploadimage' => [
                'class' => 'odilov\cropper\UploadAction',
                'url' => "/uploads/course",
                'path' => '@frontend/web/uploads/course',
                'jpegQuality' => 75,
            ]
        ];
    }

    public function actionIndex()
    {

        $searchModel = new KursSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Kurs::findModel($id),
        ]);
    }

    public function actionSections($id)
    {
        $model = Kurs::findModel($id);

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
        $model = Kurs::findModel($id);

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

    public function actionCreate()
    {
        $model = new Kurs([
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
        $model = Kurs::findModel($id);
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
//        TODO Agar birorta active enroll mavjud bo'lsa, bu kursni o'chirishga ruxsat  berilmaydi!

        $model = Kurs::findModel($id);
        if (!$model->isDeletable) {
            forbidden();
        }

        $model->delete();
        return $this->redirect('index');
    }


    public function actionEditSections($id = '')
    {
        $model = Kurs::findModel($id);
        $sections = $model->sections;
        $dform = new SDFormWidget([
            'models' => $sections,
            'modelsScenario' => 'teacher-form',
            'modelsAttributes' => ['kurs_id' => $model->id],
            'modelClass' => Section::class,
            'sortAttribute' => 'sort',
        ]);

        if ($dform->save()) {
            return $this->redirect(['/kursmanager/kurs/sections', 'id' => $id]);
        }

        return $this->render('editSections', [
            'model' => $model,
            'sections' => (empty($sections)) ? [new Section] : $sections
        ]);
    }


    /**
     * @param $id
     * @return mixed|null
     */
    public function actionKursPrice($id)
    {
        return Kurs::find()->where(['id' => $id])->one()->price;
    }


    /**
     * Kursni kutish holatidan faol holatga o'tkazish yoki kursni kutish rejimiga o'tkazish
     * @param string $id
     * @return \yii\web\Response
     * @throws Yii\web\NotFoundHttpException
     */
    public function actionApproveOrDisapprove($id = '')
    {

        $model = Kurs::findModel($id);

        /** @var Kurs $model */

        if ($model->isWaiting){

            $model->approve();
        }
        else{
            $model->disapprove();
        }

        if ($this->isAjax) {
            return $this->asJson(['forceReload' => '#crud-datatable-pjax', 'forceClose' => true]);
        }
        return $this->redirect(['kurs/index']);
    }

    public function actionChangeStatus($id)
    {
        $model = \frontend\modules\teacher\models\Kurs::findModel($id);
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

    public function actionDeleteEnroll($id)
    {
        /** @var Enroll $model */

        $model = Enroll::findModel($id);
        $model->delete();
        if ($this->isAjax){
            $this->formatJson;
            return ['forceReload'=>'#crud-datatable-pjax', 'forceClose' => true];
        }
        return $this->redirect(['kurs/students', 'id' => $model->kurs_id]);
    }


}
