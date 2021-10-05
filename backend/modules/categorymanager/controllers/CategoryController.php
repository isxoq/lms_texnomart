<?php

namespace backend\modules\categorymanager\controllers;

use Yii;
use backend\controllers\BackendController;
use backend\modules\categorymanager\models\Category;
use backend\modules\categorymanager\models\search\CategorySearch;

class CategoryController extends BackendController
{

    public function actions()
    {
        return [
            'uploadimage' => [
                'class' => 'odilov\cropper\UploadAction',
                'url' => "/uploads/category",
                'path' => '@frontend/web/uploads/category',
                'jpegQuality' => 75,
            ]
        ];
    }


    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  Category::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model =  Category::findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }


}
