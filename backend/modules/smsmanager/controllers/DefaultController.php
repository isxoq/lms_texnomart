<?php

namespace backend\modules\smsmanager\controllers;

use backend\controllers\BackendController;
use Yii;
use backend\modules\smsmanager\models\SmsSettings;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `smsmanager` module
 */
class DefaultController extends BackendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionSettings()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SmsSettings::find(),
        ]);

        return $this->render('settings', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateSettings($id='')
    {
        $model = SmsSettings::findOne($id);
        if ($model == null){
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }

        if ( $model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['settings']);
        }

        return $this->render('updateSettings', [
            'model' => $model,
        ]);

    }

    public function actionUpdateToken()
    {
        $session = Yii::$app->session;
        if(Yii::$app->sms->updateToken()){
            $session->setFlash('success', Yii::t('app', 'The token has been updated'));
        }
        else{
            $session->setFlash('success', Yii::t('app', 'An error occured while updating token! Check your email and password'));
        }
        return $this->redirect(['settings']);
    }

    public function actionTest()
    {
        $sms = Yii::$app->sms;

        dd($sms->token);
    }
}
