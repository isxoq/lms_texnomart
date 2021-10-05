<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */
/* @var $order backend\modules\ordermanager\models\Order */

$this->title = t('Thank you! Course Purchased');
$this->params['breadcrumbs'][] = ['label' => t('My orders'), 'url' => ['/shop/my-orders']];
$this->params['breadcrumbs'][] = $this->title;

$kurs = $order->kurs;

?>


<div class="bg_color_1">
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-8">
                <div class="box_cart">
                    <div class="form_title">
                        <h3><?= $this->title ?></h3>
                    </div>
                    <br>
                    <table class="table">
                        <tr>
                            <td class="order-name"><b><?= t('Order date') ?></b></td>
                            <td><?= Yii::$app->formatter->asDateUz($order->created_at) ?></td>
                        </tr>
                        <tr>
                            <td class="order-name"><b><?= t('Course name') ?></b></td>
                            <td><?= $kurs->title ?></td>
                        </tr>
                        <tr>
                            <td class="order-name"><b><?= t('Course author') ?></b></td>
                            <td><?= $kurs->user->fullname ?></td>
                        </tr>
                        <tr>
                            <td class="order-name"><b><?= t('Price') ?></b></td>
                            <td><?= $kurs->formattedPrice ?></td>
                        </tr>
                        <tr>
                            <td class="order-name"><b> <?= t('Enroll duration') ?></b></td>
                            <td><?= $kurs->durationText ?></td>
                        </tr>
                        <?php if ($order->isPayed): ?>
                            <tr>
                                <td class="order-name"><b><?= t('Payment status') ?></b></td>
                                <td><?= t('Paid up') ?></td>
                            </tr>
                        <?php endif ?>
                    </table>
                </div>
            </div>
            <!-- /col -->

            <aside class="col-lg-4" id="sidebar">
                <div class="box_detail">

                    <div id="total_cart">
                        <img src="<?= $kurs->kursImage ?>" alt="" width="100%">

                        <?= e($kurs->title) ?>
                    </div>

                    <a href="<?= to(['/profile/default/my-courses']) ?>"
                       class="btn_1 full-width outline"> <?= t('My courses') ?></a>
                </div>
            </aside>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /bg_color_1 -->


