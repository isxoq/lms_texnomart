<?php

namespace backend\modules\categorymanager;

/**
 * categorymanager module definition class
 */
class Module extends \yii\base\Module
{

    public $defaultRoute = 'category';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\categorymanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
