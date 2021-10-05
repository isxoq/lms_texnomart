<?php

namespace backend\controllers;

use Yii;
use backend\models\Testimonial;
use backend\models\search\TestimonialSearch;
use soft\web\SController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TestimonialController extends BackendController
{

    public function actionIndex()
    {
        $searchModel = new TestimonialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  Testimonial::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Testimonial();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model =  Testimonial::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


}
