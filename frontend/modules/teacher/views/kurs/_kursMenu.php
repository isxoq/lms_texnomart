<?php

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Kurs */

?>

<?= \soft\adminty\TabMenu::widget([
    'items' => [
        [
            'label' => "Kurs ma'lumotlari",
            'url' => ['/teacher/kurs/view', 'id' => $model->id],
            'icon' => '<i class="fa fa-info-circle"></i>',
        ],
        [
            'label' => "Bo'limlar",
            'url' => ['/teacher/kurs/sections', 'id' => $model->id],
            'icon' => '<i class="fa fa-list"></i>',
            'badge' => $model->getSections()->count(),
        ],
        [
            'label' => "A'zo bo'lganlar",
            'url' => ['/teacher/kurs/students', 'id' => $model->id],
            'icon' => '<i class="fa fa-users"></i>',
            'badge' => $model->getEnrollsCount(),
        ],
        [
            'label' => "Fikrlar",
            'url' => ['/teacher/kurs/comments', 'id' => $model->id],
            'icon' => '<i class="fa fa-comments"></i>',
            'badge' => $model->getActiveComments()->count(),
        ],

    ]
]) ?>
