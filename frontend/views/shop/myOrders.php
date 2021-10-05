<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */
/* @var $orders  backend\modules\ordermanager\models\Order[] */

$this->title = t('My orders');
$this->params['breadcrumbs'][] = $this->title;

?>


<main class="site-main woocommerce single single-product page-wrapper">
    <!--shop category start-->
    <section class="space-3">
        <div class="container sm-center">
            <div class="row">
                <?php if (!empty($orders)): ?>
                    <div class="col-lg-12">
                        <article id="post-6" class="post-6 page type-page status-publish hentry">
                            <!-- .entry-header -->
                            <div class="entry-content">
                                <div class="woocommerce">
                                    <div class="woocommerce-notices-wrapper"></div>
                                    <table
                                            class="shop_table shop_table_responsive cart woocommerce-cart-form__contents"
                                            cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th class="order-name"><?= t('Order #') ?></th>
                                            <th class="order-name"><?= t('Order Items') ?></th>
                                            <th class="order-name"><?= t('Order Date Time') ?></th>
                                            <th class="order-price"><?= t('Total Price') ?></th>
                                            <th class="order-status"><?= t('Order Status') ?></th>
                                            <th class="order-action"><?= t('Action') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr class="woocommerce-cart-form__cart-item cart_item">

                                                <td class="order-id" data-title="Product">
                                                    <?= ($order->id) ?>
                                                </td>

                                                <td class="order-items" data-title="Product">
                                                    <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <a href="#"><img width="324" height="324"
                                                                                     src="<?= $order->kurs->kursImage ?>"
                                                                                     class="img-responsive img-fluid attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                     alt=""></a>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <a href="#"><?= $order->kurs->title ?></a>
                                                                    <p class="price"><?= Yii::$app->formatter->asSum($order->kurs->price) ?></p>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </td>

                                                <td class="order-date" data-title="Product">
                                                    <?= Yii::$app->formatter->asDate($order->created_at) ?>
                                                </td>


                                                <td class="order-status" data-title="Product">
                                                    <?= Yii::$app->formatter->asStatus($order->status) ?>
                                                </td>
                                                <td class="order-price" data-title="Price">

                                                    <?php if ($order->status == 5): ?>

                                                        <?= \backend\modules\click\widgets\ClickButton::widget([
                                                            'order_id' => $order->id,
                                                            'amount' => $order->kurs->price,
                                                            'buttonTitle' => false,
                                                            'class' => "small"
                                                        ]) ?>

                                                    <?php endif ?>

                                                </td>

                                            </tr>

                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- .entry-content -->
                        </article>
                    </div>
                <?php else: ?>
                    <?= $this->render('_noOrdersView'); ?>
                <?php endif ?>

            </div>
        </div>
    </section>
    <!--shop category end-->
</main>
