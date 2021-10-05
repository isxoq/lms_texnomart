<?php


namespace soft\widget;


use yii\helpers\Html;

class Captcha extends \yii\captcha\Captcha
{

    public $enableClientScript = false;

    public function run()
    {
        if($this->enableClientScript){
            $this->registerClientScript();
        }
        $input = $this->renderInputHtml('text');
        $route = $this->captchaAction;
        if (is_array($route)) {
            $route['v'] = uniqid('', true);
        } else {
            $route = [$route, 'v' => uniqid('', true)];
        }
        $image = Html::img($route, $this->imageOptions);
        echo strtr($this->template, [
            '{input}' => $input,
            '{image}' => $image,
        ]);
    }

}