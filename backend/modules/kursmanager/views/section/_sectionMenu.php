<?php
    /* @var $this frontend\components\FrontendView */
    /* @var $model frontend\modules\teacher\models\Section */


?>

<?= \soft\adminty\TabMenu::widget([
    'items' => [
        [
            'label' => "Bo'lim ma'lumotlari",
            'url' => ['section/view', 'id' => $model->id],
            'icon' => '<i class="fa fa-info-circle"></i>',
        ],
        [
            'label' => "Mavzular",
            'url' => ['section/lessons', 'id' => $model->id],
            'icon' => '<i class="fa fa-list-ol"></i>',
            'badge' => $model->lessonsCount
        ],

    ]
]) ?>

