<?php

namespace backend\controllers;

use Yii;
use backend\models\EducationLevel;
use backend\models\search\EducationLevelSearch;
use soft\web\SController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class EducationLevelController extends BackendController
{

    public function actionIndex()
    {
        $searchModel = new EducationLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  EducationLevel::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new EducationLevel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model =  EducationLevel::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


}
