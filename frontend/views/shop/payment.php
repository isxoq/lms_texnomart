<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */
/* @var $order backend\modules\ordermanager\models\Order */

$this->title = t('Purchase course');
$this->params['breadcrumbs'][] = ['label' => t('My orders'), 'url' => ['/shop/my-orders']];
$this->params['breadcrumbs'][] = $this->title;

$kurs = $order->kurs;

?>

<section class="shop-checkouts">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-8">
                <h3 align="center">Buyurtma tafsilotlari</h3>

                <div class="">
                    <table class="table">
                        <tr>
                            <td class="order-name"><b>Buyurtma raqami</b></td>
                            <td><?= $order->id ?></td>
                        </tr>
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
            <div class="col-lg-4 col-xl-4">
                <div class="order_sidebar_widget mb30">

                    <ul>
                        <li class="subtitle"><img src="<?= $kurs->kursImage ?>" alt="" width="100%"></li>
                        <li>&nbsp;</li>
                        <li class="subtitle"><h3 align="center">  <?= e($kurs->title) ?></h3></li>
                        <li class="subtitle">
                            <p><?= t('Price') ?>
                                <span class="float-right totals color-orose">
                                        <?= $kurs->formattedPrice ?>
                                </span>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="">
                    <button data-toggle="modal" data-target="#offline-payment-info-modal"
                            class="btn btn-block btn-lg btn-primary">
                        <?= t('Offline payment') ?>
                    </button>
                    <br>
                    <?= \backend\modules\click\widgets\ClickButtonWidget::widget([
                        'order_id' => $order->id,
                        'amount' => $order->kurs->price,
                        'submitButtonOptions' => [
                            'class' => 'btn btn-block btn-lg btn-primary',
                        ]
                    ]) ?>
                    <br>
                    <a href="<?= to(['course/all']) ?>" class="btn btn-lg btn-block btn-success">Kurslarga qaytish</a>

                </div>
            </div>
        </div>
    </div>
</section>

