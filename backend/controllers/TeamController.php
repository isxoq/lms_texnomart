<?php

namespace backend\controllers;

use Yii;
use backend\models\Team;
use backend\models\search\TeamSearch;
use soft\web\SController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TeamController extends BackendController
{

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => 'odilov\cropper\UploadAction',
                'url' => "/uploads/team",
                'path' => '@frontend/web/uploads/team',
                'jpegQuality' => 75,
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  Team::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Team();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model =  Team::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


}
