<?php

namespace backend\modules\socialmanager\controllers;

use Yii;
use backend\controllers\BackendController;
use backend\modules\socialmanager\models\Social;
use backend\modules\socialmanager\models\search\SocialSearch;

class DefaultController extends BackendController
{
    public function actionIndex()
    {
        $searchModel = new SocialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Social::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Social();

        if ($this->modelSave($model)) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Social::findModel($id);

        if ( $model->loadSave()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
