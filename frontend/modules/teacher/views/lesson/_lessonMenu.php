<?php
    /* @var $this frontend\components\FrontendView */
    /* @var $model frontend\modules\teacher\models\Lesson */

    $action = Yii::$app->controller->action->id;


    echo \soft\adminty\TabMenu::widget([

            'items' => [
                [
                    'label' => "Mavzu haqida",
                    'url' => ['/teacher/lesson/view', 'id' => $model->id],
                    'icon' => '<i class="fa fa-info-circle"></i>',
                ],
                [
                    'label' => "Fayllar",
                    'url' => ['/teacher/lesson/files', 'id' => $model->id],
                    'icon' => '<i class="fa fa-download"></i>',
                    'badge' => $model->getFilesCount(),
                ],
                [
                    'label' => "Topshiriqlar",
                    'url' => ['/teacher/lesson/tasks', 'id' => $model->id],
                    'icon' => '<i class="fa fa-edit"></i>',
                    'badge' => $model->getTasks()->count(),
                    'visible' => false,
                ],

            ]

    ]);

?>

