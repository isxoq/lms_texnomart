<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

use frontend\models\Post;
use backend\modules\postmanager\models\PostCategory;

$latestPosts = Post::recentPosts();

$categories = PostCategory::getDataForBlogSidebar();


?>


<div class="widget">
    <form role="search" action="<?= to(['blog/index']) ?>" class="search-form">
        <div class="form-group">
            <input type="text" required name="search" class="form-control" placeholder="<?= t('Search') ?>"
                   value="<?= $this->request->get('search') ?>">
        </div>
        <button type="submit" id="submit" class="btn_1 rounded"> <?= t('Search') ?></button>
    </form>
</div>
<!-- /widget -->
<div class="widget">
    <div class="widget-title">
        <h4><?= t('Latest posts') ?></h4>
    </div>
    <ul class="comments-list">
        <?php foreach ($latestPosts as $latestPost): ?>

            <?php $latestPostUrl = to(['blog/detail', 'id' => $latestPost['slug']]) ?>

            <li>
                <div class="alignleft">
                    <a href="<?= $latestPostUrl ?>">
                        <img src="<?= $latestPost['image'] ?>"
                             alt=""></a>
                </div>
                <small><?= Yii::$app->formatter->asDateUz($latestPost['published_at']) ?></small>
                <h3><a href="<?= $latestPostUrl ?>" title=""><?= $latestPost['translation']['title'] ?></a></h3>
            </li>

        <?php endforeach ?>
    </ul>
</div>
<!-- /widget -->
<div class="widget">
    <div class="widget-title">
        <h4><?= t('Categories') ?></h4>
    </div>
    <ul class="cats">
        <?php foreach($categories as $category): ?>

        <li>
            <a href="<?= to(['blog/index', 'category' => $category['slug']]) ?>">
                <?= $category['translation']['title'] ?>
                <span>(<?= PostCategory::getActivePostsCountById($category['id']) ?>)</span>
            </a>
        </li>

        <?php endforeach ?>
    </ul>
</div>
<!-- /widget -->