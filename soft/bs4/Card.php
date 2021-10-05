<?php

namespace soft\bs4;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * Class Card renders bs4 card
 */
class Card extends \yii\base\Widget
{

    /**
     * @var string the **primary** bootstrap contextual color type
     */
    const TYPE_PRIMARY = 'primary';

    /**
     * @var string the **secondary** bootstrap contextual color type
     */
    const TYPE_SECONDARY = 'secondary';

    /**
     * @var string the **information** bootstrap contextual color type
     */
    const TYPE_INFO = 'info';

    /**
     * @var string the **danger** bootstrap contextual color type
     */
    const TYPE_DANGER = 'danger';

    /**
     * @var string the **warning** bootstrap contextual color type
     */
    const TYPE_WARNING = 'warning';

    /**
     * @var string the **success** bootstrap contextual color type
     */
    const TYPE_SUCCESS = 'success';

    /**
     * @var string the **light** bootstrap contextual color type
     */
    const TYPE_LIGHT = 'light';

    /**
     * @var string the **light** bootstrap contextual color type
     */
    const TYPE_DARK = 'dark';

    /**
     * @var array panel container element options
     */
    public $options = [];

    /**
     * @var string panel type
     */
    public $type;

    /**
     * @var array cart header options
     */
    public $headerOptions = [];

    /**
     * @var string the text for cart header
     * Set `false` not to render cart header
     */
    public $header;

    /**
     * @var array cart body options
     */
    public $bodyOptions = [];

    /**
     * @var string the content for cart body
     */
    public $cardBody;

    public function init()
    {
        parent::init();

        if (!isset($this->options['id'])){
            $this->options['id'] = $this->getId();
        }

        Html::addCssClass($this->options, 'card');

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
//        begin cart
        echo Html::beginTag($tag, $this->options);

//        render cart header if not `false`
        if ($this->header !== false){
            Html::addCssClass($this->headerOptions, 'card-header');
            $headerTag = ArrayHelper::remove($this->headerOptions, 'tag', 'div');
            if ($this->type != null){
                Html::addCssClass($this->headerOptions, "bg-{$this->type}");
                if ($this->type != self::TYPE_LIGHT){
                    Html::addCssClass($this->headerOptions, 'text-white');
                }
            }
            echo Html::tag($headerTag, $this->header, $this->headerOptions);
        }

        Html::addCssClass($this->bodyOptions, 'card-body');
        $bodyTag = ArrayHelper::remove($this->bodyOptions, 'tag', 'div');
//        begin cart body
        echo Html::beginTag($bodyTag,  $this->bodyOptions);
    }

    public function run()
    {
        echo $this->cardBody;

        $bodyTag = ArrayHelper::remove($this->bodyOptions, 'tag', 'div');
        echo Html::endTag($bodyTag);

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        echo Html::endTag($tag);
    }


}