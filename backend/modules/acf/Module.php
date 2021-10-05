<?php

namespace backend\modules\acf;

use Yii;

/**
 * acf module definition class
 */
class Module extends \yii\base\Module
{

    /**
     * Languages in terms of name-value pairs.
     * Such as:
     * ```php
     * [
     *      'en' => 'English',
     *      'ru' => 'Russian',
     *      'uz' => 'Uzbek',
     * ]
     * ```
     * As well you can use callback function.
     * Such as:
     * ```php
     * function () {
     *   return ...;
     * }
     * ```
     * @var array|callable
     */
    public $languages = [];

    public $defaultRoute = 'field/index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\acf\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (is_callable($this->languages)){
            $this->languages  = call_user_func($this->languages);
        }

//        if (empty($this->languages)){
//            $this->languages = Yii::$app->params['languages'];
//        }
        // custom initialization code goes here
    }
}
