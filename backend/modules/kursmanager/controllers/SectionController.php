<?php

namespace backend\modules\kursmanager\controllers;

use Yii;
use soft\web\SController;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use soft\widget\SDFormWidget;
use backend\modules\kursmanager\models\Kurs;
use backend\modules\kursmanager\models\Lesson;
use backend\modules\kursmanager\models\search\LessonSearch;
use backend\modules\kursmanager\models\Section;

class SectionController extends SController
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
                ],
            ],

        ];
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  Section::findModel($id),
        ]);
    }

    /**
     * @param string $id
     * @return string
     * @throws Yii\web\NotFoundHttpException
     */
    public function actionLessons($id='')
    {

        /** @var Section $model */
        $model = Section::findModel($id);
        $searchModel = new LessonSearch();
        $query = $model->getLessons();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params, $query);

        Url::remember(Url::current());

        return $this->render('lessons', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);

    }

    /**
     * @param string $id Kurs id
     * @return array|string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($id='')
    {
        $kurs = Kurs::findModel($id);
        $model = new Section([
            'kurs_id' => $id,
        ]);

        return $this->modal([
            'model' => $model,
            'title' => $kurs->title,
            'view' => 'create',
        ]);

    }

    /**
     * @param $id Section id
     * @return array
     * @throws yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model =  Section::findModel($id);

        return $this->modal([
            'model' => $model,
            'title' => $model->kurs->title,
            'view' => 'update',
        ]);
    }

    public function actionDelete($id='')
    {
        if ($this->isAjax){
            $this->formatJson;
        }

        /** @var Section $model */
        $model = Section::findModel($id);

        if (YII_ENV_PROD && $model->kurs->isConfirmed){
            if ($model->kurs->hasActiveEnrolls){
                forbidden("Diqqat!!! Ushbu kursga a'zo bo'lgan va hozirda a'zolik muddati tugamagan o'quvchilar bor! <br> Shu tufayli sizga ushbu bo'limni o'chirishga ruxsat berilmaydi");
            }
        }

        /**
         * @see Section::beforeDelete()
         **/
        $model->delete();

        if ($this->isAjax){
            return ['forceReload'=>'#crud-datatable-pjax', 'forceClose' => true];
        }
        return $this->redirect(['/teacher/kurs/sections', 'id' => $model->kurs_id]);
    }


    public function actionEditLessons($id='')
    {

        $section = Section::findModel($id);
        $lessons = $section->lessons;
        $dform =  new SDFormWidget([
            'models' => $lessons,
            'modelsScenario' => 'teacher-form',
            'modelsAttributes' => ['section_id' => $section->id],
            'modelClass' => Lesson::class,
            'sortAttribute' => 'sort',
        ]);

        if($dform->save() ){
            return $this->redirect(['/kursmanager/section/lessons', 'id' => $section->id]);
        }

        return $this->render('editLessons', [
            'section' => $section,
            'lessons' => (empty($lessons)) ? [new Lesson] : $lessons
        ]);
    }


}
