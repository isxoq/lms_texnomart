<?php

namespace backend\modules\settings\controllers;

use backend\controllers\BackendController;
use backend\modules\settings\models\Settings;
use backend\modules\settings\models\SettingsSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ManagerController implements the CRUD actions for Settings model.
 */
class ManagerController extends BackendController
{

    /**
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Settings model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'error' => false,
                'title' => "Settings #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Yii::$app->help->getViewFooter($id),
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Settings model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Settings([
            'section' => 'site',
            'scenario' => 'create',

        ]);

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'error' => false,
                    'title' => "Yangi qo'shish",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Yii::$app->help->modalFooter,

                ];
            } else if ($model->load($request->post()) && $model->save()) {

                return [
                    'error' => false,
                    'title' => "Tahrirlash #" . $model->id,
                    'forceReload'=>'#crud-datatable-pjax',
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Yii::$app->help->modalFooter,
                ];
            } else {
                return [
                    'error' => false,
                    'title' => "Yangi qo'shish",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Yii::$app->help->modalFooter,

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Settings model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $model->prepareForActiveForm();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'error' => false,
                    'title' => "Tahrirlash #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Yii::$app->help->modalFooter,
                ];
            } else if ($model->load($request->post()) ) {

                $model->prepareToSave();
                if ($model->save()){
                    return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
                }

            } else {
                return [
                    'code' => '400',
                    'message' => 'Validate error',
                    'data' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) ) {
                $model->prepareToSave();
                if ($model->save()){
                    return $this->redirect(['index']);
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Settings model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if ($this->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => true];
        }
        else{
            return $this->redirect('index');
        }

    }

    /**
     * Delete multiple existing Settings model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys
        foreach (Settings::findAll(json_decode($pks)) as $model) {
            $model->delete();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['forceClose' => true, 'forceReload' => true];
    }

    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionChange()
    {
        $models = Settings::findAll(['section' => 'signup']);

        foreach ($models as $model) {
//            $model->section = 'signup';

            $model->key = str_replace("admisson_text", "text", $model->key);
            $model->save();
        }
    }
}
