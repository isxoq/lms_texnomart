<?php

namespace frontend\modules\teacher;

use common\models\User;
use Yii;
use yii\web\ErrorHandler;

class Modul extends \yii\base\Module
{

    public $controllerNamespace = 'frontend\modules\teacher\controllers';

    public $defaultRoute = 'kurs';

    public function init()
    {

        parent::init();

        if (is_guest()  ){
            not_found();
        }

        if (!user()->isTeacher){
            forbidden();
        }

        Yii::configure(Yii::$app, require(__DIR__ . '/config/main.php'));

        /** @var ErrorHandler $handler */
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
    }
}
