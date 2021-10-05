<?php

namespace backend\modules\kursmanager;

/**
 * kursmanager module definition class
 */
class Modul extends \yii\base\Module
{

    public $defaultRoute = 'kurs';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\kursmanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
