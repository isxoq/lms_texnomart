<?php /** @var \backend\modules\usermanager\models\User $model */ ?>

<?php
    echo \soft\adminty\TabMenu::widget([
        'items' => [
            [
                'url' => ['user/view', 'id' => $model->id],
                'label' => "Foydalanuvchi Ma'lumotlari",
                'icon' => ['class' => 'fa fa-user'],
            ],
            [
                'url' => ['user/enrolls', 'id' => $model->id],
                'label' => "A'zoliklar",
                'icon' => ['class' => 'fa fa-list'],
                'badge' => intval($model->getEnrolls()->count()),
            ],

            [
                'url' => ['user/courses', 'id' => $model->id],
                'label' => "Kurslar",
                'icon' => ['class' => 'fa fa-list'],
                'badge' => intval($model->getCourses()->count()),
            ],
        ]
    ])
?>