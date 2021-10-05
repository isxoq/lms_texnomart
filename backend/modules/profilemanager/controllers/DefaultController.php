<?php

namespace backend\modules\profilemanager\controllers;

use backend\modules\profilemanager\models\ChangePasswordForm;
use Yii;
use backend\controllers\BackendController;
use backend\modules\profilemanager\models\ProfileUser;

class DefaultController extends BackendController
{

    public function actionIndex()
    {
        $model = ProfileUser::findOne(Yii::$app->user->identity->id);
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionUpdate()
    {
        $model = ProfileUser::findOne(Yii::$app->user->identity->id);
        $model->scenario = 'update';

        if ($this->modelSave($model)) {

            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }


    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->savePassword() ){
            $this->setFlash('success', t('Your password has been changed successfully'));
            return $this->redirect('index');
        }

        return $this->render('changePassword', [
            'model' => $model
        ]);
    }


}
