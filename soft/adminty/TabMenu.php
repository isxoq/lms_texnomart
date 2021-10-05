<?php


namespace soft\adminty;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TabMenu extends Widget
{

    public $options = [];

    public $encodeLabels = true;

    /**
     * @var array Menu items
     *
     * Item elementlariga quyidagi optionlarni berish mumkin:
     * - label - string - Menu sarlavhasi
     * - linkOptions - array - Menu (a tegi uchun) optionlar,
     * - listOptions - array - Menu tashqarsidagi tag optionlari, default ['tag' => 'li']
     * - slideOptions - array - Menuning pastki qismidagi slide uchun optionlar,
     * - url - string|array - Menu ssilkasi
     * - encodeLabel - bool- Labelni encode qilish kerakmi yoki yo'qmi? Bu options $this->encodeLabel xususiyatini override qilib yuboradi
     * - icon - string|array - Ikonka, masalan: string shaklida <i class="fa fa-info-circle"></i>
     *      yoki array shaklida ['class' => 'fa fa-info-circle'], bunda tag qiymatini ham berish mumkin, tag qiymatini default qiymati - "i"
     *
     *  - active - bool - Active yoki aktive emasligi, agar berilmasa, url linkka qarab aniqlanadi
     *  - badge - string - Menu labelidan keyingi badge matni
     *  - badgeOptions- array - badge uchun html optionlar, default ['tag' => 'label', 'class' => 'badge badge-inverse-primary']
     *  - visible - bool  - agar false bo'lsa menyuda ko'rinmaydi
     *
     * usage: [
     *      [
     *          'label' => 'Menu 1',
     *          'url' => ['update', 'id' => $id],
     *          ...
     *      ],
     *      [
     *          ...
     *      ]
     * ]
     */
    public $items = [];


    public $surroundByCard = true;

    public $cardOptions=['class' => 'card'];

    public $cardBlocOptions=['class' => 'card-block tab-icon'];

    public function run()
    {

        $this->options['id'] = $this->getId();
        $items = $this->renderItems();
        $tag = ArrayHelper::remove($this->options, 'tag', 'ul');
        Html::addCssClass($this->options, 'nav nav-tabs md-tabs');
        $this->options['role'] = 'tablist';
        $content = Html::tag($tag, $items, $this->options);

        if ($this->surroundByCard){
            $cardBloc = Html::tag('div', $content, $this->cardBlocOptions);
            return Html::tag('div', $cardBloc, $this->cardOptions);
        }
        return $content;
    }

    public function renderItems()
    {
        $items = "";
        foreach ($this->items as $item) {
            $items .= $this->renderItem($item);
        }
        return $items;
    }

    public function renderItem($item)
    {

        if (!isset($item['url'])) {
            throw new InvalidArgumentException("Url must be specified");
        }

        if (isset($item['visible']) &&  $item['visible'] === false ){
            return "";
        }


        $isActive = $this->isItemActive($item);

        $linkContent = $this->renderLinkContent($item, $isActive);
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        $linkClass = 'nav-link';
        if ($isActive) {
            $linkClass .= " active";
        }

        Html::addCssClass($linkOptions, $linkClass);

        $link = Html::a($linkContent, $item['url'], $linkOptions);
        $slide = $this->renderSlide($item);

        $listOptions = ArrayHelper::getValue($item, 'listOptions', []);
        $listClass = 'nav-item';
        if ($isActive){
            $listClass .= " active";
        }
        Html::addCssClass($listOptions, $listClass);
        return Html::tag('li', $link.$slide, $listOptions);
    }

    /**
     * @param $item
     * @return mixed|string
     * @throws \Exception
     */
    private function renderLinkContent($item, $isActive = false)
    {
        $label = ArrayHelper::getValue($item, 'label');

        if (empty($label)) {
            throw new InvalidArgumentException("Label must be specified");
        }
        if (isset($item['encodeLabel']) && $item['encodeLabel']) {
            $label = Html::encode($label);
        } elseif ($this->encodeLabels) {
            $label = Html::encode($label);
        }

        $icon = $this->renderIcon($item);
        $badge = $this->renderBadge($item, $isActive);

        return $icon.$label." ".$badge;

    }

    /**
     * Checks whether a menu item is active.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return bool whether the menu item is active
     */
    private function isItemActive($item)
    {
        if (isset($item['active'])) {
            return $item['active'];
        }
        if (isset($item['url'])) {
            $item['url'] = (array)$item['url'];
            if (isset($item['url'][0])) {
                $route = Yii::getAlias($item['url'][0]);
                if (strpos($route, '/') !== 0 && Yii::$app->controller) {
                    $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
                }
                if (ltrim($route, '/') === Yii::$app->controller->route) {
                    return true;
                }
            }
        }
        return false;
    }

    private function renderIcon($item)
    {
        $icon = ArrayHelper::getValue($item, 'icon');

        if (is_array($icon)) {
            $tag = ArrayHelper::remove($icon, 'tag', 'i');
            return Html::tag($tag, '', $icon);
        }

        return $icon;

    }

    private function renderBadge($item, $isActive = false)
    {
        if (!isset($item['badge'])){
            return "";
        }
        $badgeOptions = ArrayHelper::getValue($item, 'badgeOptions', []);
        $tag = ArrayHelper::remove($badgeOptions, 'tag', 'label');
        if (!isset($badgeOptions['class'])){
            $type = $isActive ? 'primary' : 'info';
            $badgeOptions['class'] = 'badge badge-inverse-'.$type;
        }
        return Html::tag($tag, $item['badge'], $badgeOptions);
    }

    private function renderSlide($item)
    {
        $slideOptions = ArrayHelper::getValue($item, 'slideOptions', []);
        Html::addCssClass($slideOptions, 'slide');
        return Html::tag('div', '', $slideOptions);
    }

}