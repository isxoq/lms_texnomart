<?php

namespace backend\modules\menumanager\controllers;

use backend\controllers\BackendController;
use yii\web\Controller;

/**
 * Default controller for the `menumanager` module
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
}
