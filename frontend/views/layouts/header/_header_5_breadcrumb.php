<?php

/* @var $this \yii\web\View */
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 27.05.2021, 9:39
 */


?>

<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb" style="background: url('<?= settings('site', 'pages_banner') ?>')">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">
                        <?= $this->title ?>
                    </h4>
                    <?= \yii\bootstrap4\Breadcrumbs::widget([
                        'links' => $this->params['breadcrumbs'] ?? []
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</section>