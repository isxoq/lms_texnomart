<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 03.07.2021, 12:58
 */
use yii\helpers\Url;
?>

<?php

if (Yii::$app->user->isGuest): ?>
    <li><a href="<?= to(['signup/index']) ?>" role="modal-remote"><?= t('Register') ?></a></li>
    <li><a href="<?= to(['site/login', 'return_url' => Url::current()]) ?>" role="modal-remote"><?= t('Enter') ?></a></li>
<?php else: ?>
    <li>
        <a href="<?= to(['/profile/default/my-courses']) ?>"><span class="title"><?= t('My courses') ?></span></a>
    </li>
    <li>
        <a href="<?= to(['/profile/cabinet']) ?>"><?= t('Personal cabinet') ?></a>
    </li>
<?php endif ?>

