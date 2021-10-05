<?php

namespace soft\adminty;

use soft\helpers\SHtml;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Menu extends \soft\widget\Menu
{

    public $options = ['class' => 'pcoded-item pcoded-left-item'];
    public $labelTemplate = '<span class="pcoded-mtext">{label}</span>';
    public $linkTemplate = '<a href="{url}"><span class="pcoded-micon">{icon}</span>{label}{badge}</a>';
    public $badgeClass = 'success';
    public $submenuTemplate = "\n<ul class='pcoded-submenu'>\n{items}\n</ul>\n";

    protected function renderItem($item)
    {

        $replacements = [

            '{label}' => strtr($this->labelTemplate, ['{label}' => $item['label'],]),
            '{icon}' => $this->renderIcon($item),
            '{badge}' => $this->renderBadge($item),
            '{url}' => isset($item['url']) ? Url::to($item['url']) : 'javascript:void(0);',

        ];

        return strtr($this->linkTemplate, $replacements);

    }

    protected function renderItems($items)

    {

        $lines = [];

        foreach ($items as $i => $item) {

            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');

            if ($item['active']) {
                SHtml::addCssClass($options, $this->activeCssClass);
            }

            $menu = $this->renderItem($item);

            if (!empty($item['items'])) {

                SHtml::addCssClass($options, 'pcoded-hasmenu');

                if ($item['active']) {
                    SHtml::addCssClass($options, 'pcoded-trigger');
                }

                $menu .= strtr($this->submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }

            $lines[] = SHtml::tag($tag, $menu, $options);

        }

        return implode("\n", $lines);

    }

    protected function renderIcon($item)
    {
        $icon = ArrayHelper::getValue($item, 'icon');
        if ($icon == null) {
            return '';
        } else {
            return SHtml::icon($icon);
        }
    }

    protected function renderBadge($item)
    {
        $badgeLabel = ArrayHelper::getValue($item, 'badgeLabel');
        if ($badgeLabel == null) {
            return '';
        } else {
            $badgeClass = ArrayHelper::getValue($item, 'badgeClass', $this->badgeClass);
            return SHtml::tag('span', $badgeLabel, ['class' => "pcoded-badge label label-{$badgeClass}"]);
        }
    }

}

?>

