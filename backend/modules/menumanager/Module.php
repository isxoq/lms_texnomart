<?php

namespace backend\modules\menumanager;

/**
 * menumanager module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\menumanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * Menu uchun sayt bo'limlari
     */
    public function sections()
    {
        return [
            'course/all' =>'Kurslar',
            'site/about' =>'Biz haqimizda',
            'site/aloqa' =>"Bog'lanish",
            'blog/index' =>"Bizning blog",
            'site/faq' =>"Yordam - FAQ",
            'site/become-teacher' =>"O'qituvchi bo'lish",
            'site/login' =>"Saytga kirish",
            'signup/index' =>"Ro'yxatdan o'tish",
        ];

    }
}
