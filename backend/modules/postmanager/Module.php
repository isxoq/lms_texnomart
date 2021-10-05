<?php

namespace backend\modules\postmanager;

/**
 * postmanager module definition class
 */
class Module extends \yii\base\Module
{

    public $defaultRoute = 'post';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\postmanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
