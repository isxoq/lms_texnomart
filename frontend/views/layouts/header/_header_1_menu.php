<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use  backend\modules\menumanager\models\Menu;
use backend\modules\categorymanager\models\Category;

/* @var $this frontend\components\FrontendView */

$isUser = $this->hasUser;
$mainMenu = Menu::getMenu('main_menu');
$categories = Category::categoriesForMenu();

?>
<!-- Main Header Nav -->
<header class="header-nav menu_style_home_five navbar-scrolltofixed stricky main-menu">
    <div class="container-fluid">
        <!-- Ace Responsive Menu -->
        <nav>
            <!-- Menu Toggle btn-->
            <div class="menu-toggle">
                <img class="nav_logo_img img-fluid" src="images/header-logo3.png" alt="header-logo3.png">
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <a href="<?= to(['site/index']) ?>" class="navbar_brand float-left dn-smd">
                <img class="logo1 img-fluid" src="<?= settings('site', 'header_colored_logo') ?>" alt="virtualdars" style="margin-top: 19px">
                <span></span>
            </a>
            <!-- Responsive Menu Structure-->
            <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
            <div class="ht_left_widget home5 float-left">
                <ul>
                    <li class="list-inline-item">
                        <div class="header_top_lang_widget">
                            <div class="ht-widget-container">
                                <div class="vertical-wrapper">
                                    <h2 class="title-vertical home5">
                                        <span class="text-title"><?= t('Categories') ?></span> <i
                                                class="fa fa-angle-down show-down" aria-hidden="true"></i>
                                    </h2>
                                    <div class="content-vertical home5">
                                        <ul id="vertical-menu" class="mega-vertical-menu nav navbar-nav">
                                            <?php foreach ($categories as $category): ?>

                                                <?php if (empty($category['subCategories'])): ?>
                                                    <li>
                                                        <a href="<?= to(['course/all', 'category' => $category['slug']]) ?>"><?= e($category['translation']['title']) ?></a>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <a href="#"
                                                           class="dropdown-toggle" data-hover="dropdown"
                                                           data-toggle="dropdown"><?= e($category['translation']['title']) ?>
                                                            <b class="caret"></b></a>
                                                        <div class="dropdown-menu vertical-megamenu"
                                                             style="width: 300px;height: auto">
                                                            <div class="dropdown-menu-inner">
                                                                <div class="element-inner">
                                                                    <div class="element-section-wrap">
                                                                        <div class="element-container">
                                                                            <div class="element-row">
                                                                                <div class="col-lg-12">
                                                                                    <div class="element-wrapper">
                                                                                        <div class="widget-nav-menu">
                                                                                            <div class="element-list-wrapper wn-menu">
                                                                                                <ul class="element-menu-list">
                                                                                                    <?php foreach ($category['subCategories'] as $subCategory): ?>

                                                                                                        <li>
                                                                                                            <a href="<?= to(['course/all', 'sub-category' => $subCategory['slug']]) ?>"><?= e($subCategory['translation']['title']) ?></a>
                                                                                                        </li>

                                                                                                    <?php endforeach; ?>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="element-warapper-btn" style="margin-bottom: 17px">
                                                                                            <a href="<?= to(['course/all', 'category' => $category['slug']]) ?>">
                                                                                                <div class="element-wrapper-sub-title">
                                                                                                    <?= t('All courses') ?>
                                                                                                    <i class="flaticon-right-arrow-1"></i>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endif ?>

                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item dn-1440">
                        <div class="ht_search_widget">
                            <div class="header_search_widget">
                                <form class="form-inline mailchimp_form" action="<?= to(['course/all']) ?>">
                                    <input type="text" required class="form-control mb-2 mr-sm-2" id="inlineFormInputMail2"
                                           name="title"  placeholder="<?= t('Search courses') ?>" style="width: 200px">
                                    <button type="submit" class="btn btn-primary mb-2"><span
                                                class="flaticon-magnifying-glass"></span></button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item list_s dib-1440 dn">
                        <div class="search_overlay home5">
                            <a id="search-button-listener" class="mk-search-trigger mk-fullscreen-trigger" href="#">
                                <span id="search-button"><i class="flaticon-magnifying-glass"></i></span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
                <?= $this->renderDynamic('return $this->render("@frontend/views/layouts/header/__user_menu");') ?>

                <?php $mainMenuSubs = $mainMenu->subMenus; ?>

                <?php for ($i = count($mainMenuSubs) - 1; $i >= 0; $i--): ?>

                    <?php $menu = $mainMenuSubs[$i] ?>

                    <li>
                        <a href="<?= $menu->url ?>"><span class="title"><?= $menu->title ?></span></a>
                        <?php $subMenus = $menu->subMenus; ?>
                        <?php if (!empty($subMenus)): ?>
                            <ul class="sub-menu">
                                <?php foreach ($subMenus as $subMenu): ?>
                                    <li><a href="<?= $subMenu->url ?>"><?= $subMenu->title ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </li>

                <?php endfor ?>
            </ul>
        </nav>
        <!-- End of Responsive Menu -->
    </div>
</header>