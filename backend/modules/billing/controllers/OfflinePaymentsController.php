<?php

namespace backend\modules\billing\controllers;

use backend\modules\billing\models\Purchases;
use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\Kurs;
use Yii;
use backend\modules\billing\models\OfflinePayments;
use backend\modules\billing\models\search\OfflinePaymentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfflinePaymentsController implements the CRUD actions for OfflinePayments model.
 */
class OfflinePaymentsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all OfflinePayments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OfflinePaymentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OfflinePayments model.
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
     * Creates a new OfflinePayments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($user_id = '')
    {
        $model = new OfflinePayments();
        $model->user_id = $user_id;
        $model->duration = '+1 year';

        if ($model->load(Yii::$app->request->post())) {

            $model->created_at = date('U');
            $model->updated_at = date('U');
            $model->status = OfflinePayments::ACCEPTED;
            if ($model->save()) {

                Yii::$app->billing->newPurchase([

                    'user_id' => $model->user_id,
                    'user_revenue_percentage' => $model->user->revenue_percentage,
                    'course_id' => $model->course_id,
                    'order_id' => null,
                    'transaction_id' => $model->id,
                    'amount' => $model->amount,
                    'payment_type' => 'offline_payment',
                    'status' => Purchases::PURCHASE_ACCEPTED

                ]);

                $enroll = Enroll::findOrCreateModel($model->user_id, $model->course_id);
                $enroll->type = Enroll::TYPE_PURCHASED;
                $enroll->generateEndTime($model->duration);
                $enroll->sold_price = $model->amount;
                $enroll->created_at = strtotime('now');
                $enroll->created_by = Yii::$app->user->identity->id;
                if (!$enroll->save()) {
                    dd($enroll->errors);
                }
                return $this->redirect(['index']);
            } else {
                dd($model->errors);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OfflinePayments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OfflinePayments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OfflinePayments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OfflinePayments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OfflinePayments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    /**
     * @param $id
     * @return mixed|null
     */
    public function actionKursInfo($id)
    {

        $result = [];
        $kurs = Kurs::findOne($id);
        if ($kurs != null){
            $result = [
              'price' => $kurs->price,
              'duration' => $kurs->duration,
            ];
        }
        Yii::$app->response->format = 'json';
        return $result;
        return $this->asJson($result);
    }

}
