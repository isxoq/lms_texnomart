<?php

namespace backend\modules\kursmanager\controllers;

use soft\web\SController;
use Yii;
use backend\modules\kursmanager\models\KursComment;
use backend\modules\kursmanager\models\search\KursCommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KursCommentController implements the CRUD actions for KursComment model.
 */
class KursCommentController extends SController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all KursComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KursCommentSearch();
        $query = KursComment::find()->andWhere([ 'reply_id' =>  null]);
        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KursComment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new KursComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KursComment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing KursComment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($this->isAjax) {

            $this->formatJson;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            return [

                'title' => 'Tahrirlash #' . $id,
                'content' => $this->renderAjax('update', ['model' => $model]),
                'footer' => Yii::$app->help->modalFooter,

            ];


        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }


    }

    public function actionReply($id)
    {
        $model = $this->findModel($id);
        $replyModel = new KursComment([
            'user_id' => user()->id,
            'reply_id' => $model->id,
        ]);

        if ($this->isAjax) {

            $this->formatJson;

            if ($replyModel->load(Yii::$app->request->post()) && $replyModel->save()) {
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            return [

                'title' => 'Javob yozish #' . $id,
                'content' => $this->renderAjax('reply', [
                    'model' => $model,
                    'replyModel' => $replyModel,
                ]),
                'footer' => Yii::$app->help->modalFooter,

            ];


        } else {
            if ($replyModel->load(Yii::$app->request->post()) && $replyModel->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('reply', [
                'model' => $model,
                'replyModel' => $replyModel,
            ]);
        }


    }

    /**
     * Deletes an existing KursComment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            return $this->asJson(['forceReload' => '#crud-datatable-pjax', 'forceClose' => true]);
        }
        return $this->redirect(['kurs-comment/index']);
    }

    /**
     * Finds the KursComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KursComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KursComment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionChangeStatus($id, $status)
    {

        $model = $this->findModel($id);

        $model->status = $status;
        $model->save();

        if (Yii::$app->request->isAjax) {
            return $this->asJson(['forceReload' => '#crud-datatable-pjax', 'forceClose' => true]);
        }
        return $this->redirect(['kurs-comment/index']);
    }


    public function actionBulkChangeStatus($status)
    {
        $pks = explode(',', request()->post('pks'));
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->status = $status;
            $model->save();
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {

            return $this->redirect(['index']);
        }
    }

}
