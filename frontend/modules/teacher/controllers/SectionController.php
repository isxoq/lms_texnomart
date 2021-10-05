<?php

namespace frontend\modules\teacher\controllers;

use frontend\components\UserHistoryBehavior;
use frontend\modules\teacher\models\Kurs;
use frontend\modules\teacher\models\Lesson;
use frontend\modules\teacher\models\search\LessonSearch;
use soft\widget\SDFormWidget;
use Yii;
use frontend\modules\teacher\models\Section;
use frontend\modules\teacher\models\search\SectionSearch;
use soft\web\SController;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class SectionController extends SController
{

    public function behaviors()
    {
        return [
            UserHistoryBehavior::class,
        ];
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  Section::findOwnModel($id),
        ]);
    }

    public function actionLessons($id='')
    {

        $model = Section::findOwnModel($id);
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
        $kurs = Kurs::findOwnModel($id);
        $model = new Section([
            'scenario' => 'teacher-form',
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
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model =  Section::findOwnModel($id);
        $model->scenario = 'teacher-form';

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

        $model = Section::findOwnModel($id);

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

        $section = Section::findOwnModel($id);
        $lessons = $section->lessons;
        $dform =  new SDFormWidget([
            'models' => $lessons,
            'modelsScenario' => 'teacher-form',
            'modelsAttributes' => ['section_id' => $section->id],
            'modelClass' => Lesson::class,
            'sortAttribute' => 'sort',
        ]);

        if($dform->save() ){
            return $this->redirect(['/teacher/section/lessons', 'id' => $section->id]);
        }

        return $this->render('editLessons', [
            'section' => $section,
            'lessons' => (empty($lessons)) ? [new Lesson] : $lessons
        ]);
    }


}
