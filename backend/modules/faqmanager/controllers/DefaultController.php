<?php

namespace backend\modules\faqmanager\controllers;

use backend\controllers\BackendController;
use backend\modules\faqmanager\models\Faq;
use soft\widget\SDFormWidget;
use Yii;
use backend\modules\faqmanager\models\FaqCategory;
use backend\modules\faqmanager\models\FaqCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for FaqCategory model.
 */
class DefaultController extends BackendController
{

    /**
     * Lists all FaqCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FaqCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FaqCategory model.
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
     * Creates a new FaqCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FaqCategory();

        $models = [new Faq()];

        $dform =  new SDFormWidget([
            'model' => $model,
            'models' => $models,
            'modelsAttributes' => ['category_id' => $model->id],
            'modelClass' => Faq::class,
            'sortAttribute' => 'sort',
            'deleteOldModels' => true,
        ]);

        if($dform->save() ){
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
            'models' => $models,
        ]);
    }

    /**
     * Updates an existing FaqCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $models = $model->faqs;

        $dform =  new SDFormWidget([
            'model' => $model,
            'models' => $models,
            'modelsAttributes' => ['category_id' => $model->id],
            'modelClass' => Faq::class,
            'sortAttribute' => 'sort',
            'deleteOldModels' => true,
        ]);

        if($dform->save() ){
            return $this->redirect('index');
        }


        return $this->render('update', [
            'model' => $model,
            'models' => empty($models) ? [new Faq()] : $models,
        ]);
    }

    /**
     * Deletes an existing FaqCategory model.
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
     * Finds the FaqCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FaqCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FaqCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
