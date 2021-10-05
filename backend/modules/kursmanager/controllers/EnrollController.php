<?php

namespace backend\modules\kursmanager\controllers;

use backend\controllers\BackendController;
use soft\web\SController;
use Yii;
use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\search\EnrollSearch;
use yii\web\NotFoundHttpException;

class EnrollController extends BackendController
{

    public function actionIndex()
    {
        $searchModel = new EnrollSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  Enroll::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Enroll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var Enroll $model */
        $model =  Enroll::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        /** @var Enroll $model */
        $model = Enroll::findModel($id);
        $model->delete();
        if ($this->isAjax){
            $this->formatJson;
            return ['forceReload'=>'#crud-datatable-pjax', 'forceClose' => true];
        }
        else{
            return $this->back();
        }
    }



}
