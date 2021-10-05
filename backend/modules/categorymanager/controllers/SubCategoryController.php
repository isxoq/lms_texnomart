<?php

namespace backend\modules\categorymanager\controllers;

use backend\controllers\BackendController;
use backend\modules\categorymanager\models\Category;
use Yii;
use backend\modules\categorymanager\models\SubCategory;
use backend\modules\categorymanager\models\search\SubCategorySearch;
use soft\web\SController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SubCategoryController extends BackendController
{

    public function actionIndex()
    {
        $searchModel = new SubCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  SubCategory::findModel($id),
        ]);
    }

    public function actionCreate($category_id)
    {
        $category = Category::findModel($category_id);
        $model = new SubCategory();

        $model->category_id = $category->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['category/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'category' => $category,
        ]);
    }

    public function actionUpdate($id)
    {
        $model =  SubCategory::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['category/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = SubCategory::findModel($id);
        $model->delete();
        if($this->isAjax){
            Yii::$app->response->format = 'json';
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->redirect(['category/index']);
        }
    }


}
