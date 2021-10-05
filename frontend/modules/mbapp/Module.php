<?php

namespace frontend\modules\mbapp;

use Yii;

/**
 * mbapp module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\mbapp\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->setLanguage();

        // custom initialization code goes here
    }

    public function setLanguage()
    {
        $lang = Yii::$app->request->get('lang', 'uz');
        $languages = Yii::$app->site->languages();
        if (!array_key_exists($lang, $languages )){
            $lang = 'uz';
        }
        Yii::$app->language = $lang;
    }

}
