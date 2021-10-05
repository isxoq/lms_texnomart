<?php


namespace soft\adminty;


class Breadcrumbs extends \yii\bootstrap4\Breadcrumbs
{

    public $tag = 'ul';

    public $encodeLabels = false;

    public $navOptions = [];

    public $homeLink = [
        'url' => ['/site/index'],
        'label' => '<i class="feather icon-home"></i>',
    ];

    public $options = ['class' => 'breadcrumb-title'];

    public $template = "<li class='breadcrumb-item' style='float: left;'>{link}</li>";

    public $activeItemTemplate = " <li class='breadcrumb-item'  style='float: left;'>{link}</li>";


}