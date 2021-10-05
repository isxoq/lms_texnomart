<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */

$recentPosts = \frontend\models\Post::recentPostsForIndexPage();

?>

<div class="bg_color_1">
    <div class="container margin_120_95">
        <div class="main_title_2">
            <span><em></em></span>
            <h2><?= t('Our blog text on index page') ?></h2>
            <p><?= t('Our blog small text on index page') ?></p>
        </div>
        <div class="row">
            <?php foreach($recentPosts as $latestPost): ?>

                <?php $latestPostUrl = to(['blog/detail', 'id' => $latestPost['slug']]) ?>


                <div class="col-lg-6">
                <a class="box_news" href="<?= $latestPostUrl ?>">
                    <figure><img src="<?= $latestPost['image'] ?>" alt="">
                    </figure>
                    <ul>
                        <li><?= Yii::$app->formatter->asDateUz($latestPost['published_at']) ?></li>
                    </ul>
                    <h4><?= $latestPost['translation']['title'] ?></h4>
                    <p>
                        <?= Yii::$app->formatter->asShortText($latestPost['translation']['content'], 100) ?>
                    </p>
                </a>
            </div>

            <?php endforeach ?>
        </div>
        <!-- /row -->
        <p class="btn_home_align"><a href="<?= to(['blog/index']) ?>" class="btn_1 rounded"><?= t('View all news') ?></a></p>
    </div>
    <!-- /container -->
</div>
