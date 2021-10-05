<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/**
 * Order bo'sh bo'lgan holati uchun partial view
 **/

/* @var $this frontend\components\FrontendView */
?>

<div class="col-lg-12">
    <span class="h3 text-muted"><?= t('There are no orders in your profile') ?></span>
    <br>
    <br>
    <a href="<?= to(['/course/all']) ?>" class="btn btn-main"><?= t('All courses') ?></a>
</div>
