<?php
/* @var $lesson backend\modules\kursmanager\models\Lesson */

$activeMedias = $lesson->activeMedias;

?>

<div class="card mb-1">
    <div class="card-body p-1" style="min-height: 43px">
        <div class="start-pills">
            <ul class="nav nav-pills">
                <?php if (!empty($activeMedias)): ?>
                    <?php foreach ($activeMedias as $key => $media): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= to(['lesson', 'id' => $lesson->id, 'media' => $key+1]) ?>"> <?= fa('video') ?> Video <?= $key + 1 ?></a>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
            </ul>
        </div>
    </div>
</div>