<?php

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 27.05.2021, 9:48
 */

use backend\modules\menumanager\models\Menu;
use backend\modules\socialmanager\models\Social;

/* @var $this \yii\web\View */

$additionalMenuItems = Menu::getMenu('additional_menu')->subMenus;
$socials = Social::getDataForClientSide();

?>

<!-- Our Footer Middle Area -->
<section class="footer_middle_area p0">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 pb15 pt15">
                <div class="logo-widget home1">
                    <img class="img-fluid" src="<?= settings('site', 'site_footer_logo') ?>" alt="virtualdars"
                         style="margin-top: 19px">
                    <span></span>
                </div>
            </div>
            <div class="col-sm-8 col-md-5 col-lg-6 col-xl-6 pb25 pt25 brdr_left_right">
                <div class="footer_menu_widget">

                    <?php if (!empty($additionalMenuItems)): ?>
                        <ul>

                            <?php foreach ($additionalMenuItems as $item): ?>
                                <li class="list-inline-item"><a href="<?= $item->url ?>"><?= $item->title ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-4 pb15 pt15">
                <div class="footer_social_widget mt15">
                    <ul>

                        <?php foreach ($socials as $social): ?>
                            <li  class="list-inline-item">
                                <a href="<?= Yii::$app->urlManager->absoluteUrl($social['url']) ?>" target="_blank">
                                    <i class="<?= $social['icon'] ?>"></i>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
