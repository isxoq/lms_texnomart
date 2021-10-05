<?php

/* @var $this \frontend\components\FrontendView */
?>


<?php if (!$this->hasUser): ?>
    <li><a href="<?= to(['site/login']) ?>"><span class="flaticon-user"></span> <?= t('Enter') ?></a></li>
    <li><a href="<?= to(['signup/index']) ?>"><span class="flaticon-edit"></span> <?= t('Register') ?></a></li>
<?php else: ?>


    <li>
        <a href="<?= to(['/profile/default/my-courses']) ?>"><span class="title"><?= t('My courses') ?></span></a>
    </li>

    <li class="">
        <a href="#">
            <span class="title">
                <span class="flaticon-user"></span> <?= user('firstname') ?>
            </span>
        </a>
        <ul class="sub-menu">
            <?php if (user('isTeacher')): ?>
                <li><a href="<?= to(['/teacher']) ?>"><?= t('Course controller') ?></a></li>
            <?php endif ?>
            <li>
                <a href="<?= to(['/profile/cabinet']) ?>"><?= t('Personal cabinet') ?></a>
            </li>
            <?php if (!user('isTeacher')): ?>
                <li>
                    <a href="<?= to(['/site/become-teacher']) ?>"><?= t('Become Instructor') ?></a>
                </li>
            <?php endif ?>

            <li>
                <a href="#" class="logout-menu-link"><?= t('Logout') ?></a>
            </li>

        </ul>
    </li>


<?php endif ?>