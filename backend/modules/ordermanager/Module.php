<?php

namespace backend\modules\ordermanager;

/**
 * ordermanager module definition class
 */
class Module extends \yii\base\Module
{

    public $defaultRoute = 'order';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\ordermanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
