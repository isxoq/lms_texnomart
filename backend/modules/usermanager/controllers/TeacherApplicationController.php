<?php

namespace backend\modules\usermanager\controllers;

use backend\controllers\BackendController;
use Yii;
use backend\modules\usermanager\models\TeacherApplication;
use backend\modules\usermanager\models\search\TeacherApplicationSearch;
use soft\web\SController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TeacherApplicationController extends BackendController
{

    public function actionIndex()
    {
        $searchModel = new TeacherApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  TeacherApplication::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new TeacherApplication();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return array|string|\yii\web\Response
     * @throws \Yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model =  TeacherApplication::findModel($id);

        if ($model->isNew){
            $model->status = TeacherApplication::STATUS_WAITING;
        }

        if ($this->isAjax){

            $this->getFormatJson();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return ['forceReload'=>'#crud-datatable-pjax', 'forceClose' => true];
            }

            return [

                'title' => 'Tahirlash#'.$model->id,
                'content' => $this->renderAjax('update', ['model' => $model]),
                'footer' => Yii::$app->help->modalFooter,
            ];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDownloadFile($id='')
    {
        $model = TeacherApplication::findModel($id);
        if($model->hasFile){
            return Yii::$app->response->sendFile($model->filePath);
        }
       else{
           not_found('This application has not a file!');
       }
    }

    public function actionApprove($id='')
    {
        $model = TeacherApplication::findModel($id);
        $model->approve();
        return $this->redirect('index');
    }

    public function actionDelete($id='')
    {
        if ($this->isAjax){
            $this->formatJson;
        }
        TeacherApplication::findModel($id)->delete();

        if ($this->isAjax){

            return ['forceReload'=>'#crud-datatable-pjax', 'forceClose' => true];

        }
        return $this->redirect(['index']);
    }

}
