<?php

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Kurs */

?>

<?= \soft\adminty\TabMenu::widget([
    'items' => [
        [
            'label' => "Kurs ma'lumotlari",
            'url' => ['kurs/view', 'id' => $model->id],
            'icon' => '<i class="fa fa-info-circle"></i>',
        ],
        [
            'label' => "Bo'limlar",
            'url' => ['kurs/sections', 'id' => $model->id],
            'icon' => '<i class="fa fa-list"></i>',
            'badge' => $model->getSections()->count(),
        ],
        [
            'label' => "A'zo bo'lganlar",
            'url' => ['kurs/students', 'id' => $model->id],
            'icon' => '<i class="fa fa-users"></i>',
            'badge' => $model->getEnrollsCount(),
        ],

    ]
]) ?>
