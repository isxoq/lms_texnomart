<?php

namespace backend\modules\ordermanager\controllers;

use Yii;
use backend\controllers\BackendController;
use backend\modules\ordermanager\models\Order;
use backend\modules\ordermanager\models\search\OrderSearch;

class OrderController extends BackendController
{

    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  Order::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model =  Order::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        Order::findModel($id)->delete();
        if ($this->isAjax){
            $this->formatJson;
            return ['forceReload'=>'#crud-datatable-pjax', 'forceClose' => true];
        }
        return $this->back();
    }

}
