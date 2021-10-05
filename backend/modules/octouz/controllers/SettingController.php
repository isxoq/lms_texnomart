<?php

namespace backend\modules\octouz\controllers;

use backend\controllers\BackendController;
use yii;

class SettingController extends BackendController
{
    public function actionIndex()
    {
        $model = \backend\modules\octouz\models\Octouz::find()->one();

        if (!$model) {
            $model = new \backend\modules\octouz\models\Octouz();
        }

        return $this->render('index', compact('model'));
    }

    public function actionUpdate()
    {
        $model = \backend\modules\octouz\models\Octouz::find()->one();

        if (!$model) {
            $model = new \backend\modules\octouz\models\Octouz();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                return $this->redirect('index');
                return;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}
