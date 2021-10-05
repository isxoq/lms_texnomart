<?php

/* @var $this \yii\web\View */
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 14:22
 */


?>

<!-- Modal Search Button Bacground Overlay -->
<div class="search_overlay dn-992">
    <div class="mk-fullscreen-search-overlay" id="mk-search-overlay">
        <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button">
            <i class="fa fa-times"></i>
        </a>
        <div id="mk-fullscreen-search-wrapper">
            <form method="get" id="mk-fullscreen-searchform" action="<?= to(['course/all']) ?>">
                <input type="text" value="" placeholder="<?= t('Search courses') ?>..." name="title"
                       id="mk-fullscreen-search-input" required>
                <i class="flaticon-magnifying-glass fullscreen-search-icon"><input value="" type="submit"></i>
            </form>
        </div>
    </div>
</div>

