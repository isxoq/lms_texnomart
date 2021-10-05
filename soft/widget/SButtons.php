<?php


namespace soft\widget;

use soft\extra\STemplate;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SButtons extends Widget
{

    public const SIZE = [
        'large' => 'btn-group-lg',
        'small' => 'btn-group-sm',
    ];

    public $options = [];

    public $buttons = [];

    public $template = -1;

    public $group = true;

    public $size;

    public $vertical = false;


    public function run()
    {

        if (!isset($this->options['id'])){
            $this->options['id'] = $this->getId();
        }

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');

        if ($this->group){

            $class = $this->vertical ? "btn-group-vertical" : "btn-group";
            Html::addCssClass($this->options, $class);

            if ($this->size != null){
                Html::addCssClass($this->options, $this->size);
            }

        }

        return Html::tag($tag, $this->renderButtons(), $this->options);


    }

    public function renderButtons()
    {
        if ($this->buttons == false || $this->buttons == '') {
            return "";
        }
        if (!is_array($this->buttons)) {
            return $this->buttons;
        }

        $buttons = [];
        foreach ($this->buttons as $buttonName => $buttonConfig) {
            $buttons[$buttonName] = SButton::widget([
                'config' => $buttonConfig
            ]);
        }

        $buttons = STemplate::widget([
            'template' => $this->template,
            'items' => $buttons,
        ]);

        return $buttons;

    }


}