<?php


namespace backend\modules\click\widgets;


use Yii;
use yii\base\Widget;
use backend\modules\click\components\ClickData;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ClickButtonWidget extends Widget
{

    public $options = [];

    public $order_id;
    public $amount;
    public $merchant_id;
    public $merchant_user_id;
    public $service_id;

    /**
     * @var array Html options for submit button
     * --content -string- Content for submit button
     * @example
     *  [
     *      'content' => 'Pay with click',
     *      'class' => 'btn btn-success',
     *      ...
     *  ]
     */
    public $submitButtonOptions = [];


    public function init()
    {

        $this->merchant_id = ClickData::MERCHANT_ID;
        $this->merchant_user_id = ClickData::MERCHANT_USER_ID;
        $this->service_id = ClickData::SERVICE_ID;
    }

    public function run()
    {


        $form =
            <<<HTML
                      <form id="click_form" action="https://my.click.uz/services/pay" method="get" target="_blank">
                                            <input type="hidden" name="amount" value="$this->amount"/>
                                            <input type="hidden" name="merchant_id" value="$this->merchant_id"/>
                                            <input type="hidden" name="merchant_user_id" value="$this->merchant_user_id"/>
                                            <input type="hidden" name="service_id" value="$this->service_id"/>
                                            <input type="hidden" name="transaction_param" value="$this->order_id"/>
                                            <input type="hidden" name="return_url" value="https://virtualdars.uz/profile/my-courses"/>
                                            <input type="hidden" name="card_type" value=""/>
                                            {$this->renderSubmitButton()}
                                        </form>
HTML;


        $this->options['id'] = $this->getId();

        return Html::tag('div', $form, $this->options);


    }


    private function renderSubmitButton()
    {

        $content = ArrayHelper::remove($this->submitButtonOptions, 'content', Yii::t('app', 'Pay with CLICK'));
        return Html::submitButton($content, $this->submitButtonOptions);

    }

}