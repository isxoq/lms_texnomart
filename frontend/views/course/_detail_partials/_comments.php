<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 29.05.2021, 11:23
 */


/* @var $this \yii\web\View */
/* @var $model \backend\modules\kursmanager\models\KursComment|\frontend\models\Kurs */
/* @var $comments array */
?>

<div class="cs_row_six csv2">
    <div class="sfeedbacks">
        <h4 class="aii_title">Fikrlar</h4>
        <div class="mbp_pagination_comments">
            <?php foreach ($comments as $comment): ?>

                <?php
                $user = $comment['user'];
                $replies = $comment['replies'];
                $rating = $comment['rating'];
                $hasReplies = !empty($replies);
                ?>

                <div class="mbp_first media csv1 mb-4">
                    <img src="<?= $user['avatar'] ?? Yii::$app->settings->get('site', 'user_default_avatar') ?>"
                         class="mr-3"
                         alt="user image" style="border-radius: 100%">
                    <div class="media-body">
                        <h4 class="sub_title mt-0"><?= $user['firstname'] . ' ' . $user['lastname'] ?> &nbsp;&nbsp;
                            <a class="sspd_postdate fz14 text-muted">
                                <?= date('H:i d.m.Y', $comment['created_at']) ?>
                            </a>
                            <span class="sspd_review float-right">
                                <ul>
                                    <?= Yii::$app->help->stars($rating['rate'], '<li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>', '<li class="list-inline-item"><a href="#"><i class="fa fa-star-o"></i></a></li>') ?>
                                </ul>
                            </span>
                        </h4>

                        <p class="fz15 mt10">
                            <?= Yii::$app->formatter->asHtml($comment['text']) ?>
                        </p>
                        <?php if ($hasReplies): ?>
                            <?php foreach ($replies as $reply): ?>
                                <div class="mbp_sub media csv1" style="margin: 30px 0 20px 0;">
                                    <a href="#">
                                        <img src="<?= $reply['user']['avatar'] ?? Yii::$app->settings->get('site', 'user_default_avatar') ?>"
                                             class="mr-3" alt="" style="border-radius: 100%">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="sub_title mt-0">
                                            <?= $reply['user']['firstname'] . ' ' . $reply['user']['lastname'] ?>
                                            <a class="sspd_postdate fz14 text-muted">
                                                <?= date('H:i d.m.Y', $reply['created_at']) ?>
                                            </a>
                                        </h4>
                                        <p class="fz15 mt10 mb10">  <?= Yii::$app->formatter->asHtml($reply['text']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </div>
</div>
