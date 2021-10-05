<?php

namespace frontend\modules\profile;

use Yii;
use yii\web\ErrorHandler;

/**
 * profile module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\profile\controllers';

    public function init()
    {
        parent::init();
        Yii::configure(Yii::$app, require(__DIR__ . '/config/main.php'));

        /** @var ErrorHandler $handler */
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
    }
}
