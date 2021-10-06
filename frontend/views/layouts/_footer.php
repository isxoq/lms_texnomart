<?php

/* @var $this \yii\web\View */
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use backend\modules\menumanager\models\Menu;
use backend\modules\socialmanager\models\Social;

$footerMenu = Menu::getMenu('footer_menu');
$additionalMenuItems = Menu::getMenu('additional_menu')->subMenus;
$socials = Social::getDataForClientSide();

$phoneNumber = settings('site', 'company_phone_number');
$email = settings('site', 'company_email');



?>

<?= $this->render('footer/_footer_1_top') ?>
<?= $this->render('footer/_footer_2_middle') ?>
<?//= $this->render('footer/_footer_3_bottom') ?>

