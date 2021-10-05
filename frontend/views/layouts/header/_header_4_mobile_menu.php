<?php

/* @var $this \frontend\components\FrontendView */

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 27.05.2021, 9:39
 */

use backend\modules\menumanager\models\Menu;

$mainMenu = Menu::getMenu('main_menu');

?>

<!-- Main Header Nav For Mobile -->
<div id="page" class="stylehome1 h0">
    <div class="mobile-menu">
        <div class="header stylehome1">
            <div class="main_logo_home2">

                <img class="nav_logo_img img-fluid float-left mt20" src="<?= settings('site', 'site_top_logo') ?>"
                     alt="virtualdars">

                <span></span>
            </div>
            <ul class="menu_bar_home2">
                <li class="list-inline-item">
                    <div class="search_overlay">
                        <a id="search-button-listener2" class="mk-search-trigger mk-fullscreen-trigger" href="#">
                            <div id="search-button2"><i class="flaticon-magnifying-glass"></i></div>
                        </a>
                        <div class="mk-fullscreen-search-overlay" id="mk-search-overlay2">
                            <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button2"><i
                                        class="fa fa-times"></i></a>
                            <div id="mk-fullscreen-search-wrapper2">
                                <form method="get" id="mk-fullscreen-searchform2" action="<?= to(['course/all']) ?>">
                                    <input type="text" value="" placeholder="<?= t('Search courses') ?>..."
                                           id="mk-fullscreen-search-input2" name="title">
                                    <i class="flaticon-magnifying-glass fullscreen-search-icon">
                                        <input value="" type="submit"></i>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-inline-item"><a href="#menu"><span></span></a></li>
            </ul>
        </div>
    </div><!-- /.mobile-menu -->
    <nav id="menu" class="stylehome1">
        <ul>
            <li><a href="<?= to(['site/index']) ?>"><?= t('Home') ?></a></li>
            <?php foreach ($mainMenu->subMenus as $menu): ?>

                <?php $subMenus = $menu->subMenus; ?>
                <?php if (!empty($subMenus)): ?>
                    <li><span><?= $menu->title ?></span>
                        <ul>
                            <?php foreach ($subMenus as $subMenu): ?>
                                <li><a href="<?= $subMenu->url ?>"><?= $subMenu->title ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="<?= $menu->url ?>"><?= $menu->title ?></a></li>
                <?php endif ?>
            <?php endforeach; ?>

            <?= $this->renderDynamic('return $this->render("@frontend/views/layouts/header/__user_mobile_menu");') ?>

        </ul>
    </nav>
</div>