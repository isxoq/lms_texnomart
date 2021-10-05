<?php

/* @var $this frontend\components\FrontendView */
/* @var $enroll frontend\modules\teacher\models\Enroll*/
?>

<?= \soft\adminty\DetailView::widget([
    'model' => $enroll,
    'panel' => false,
    'attributes' => [
        'kurs.title',
       [
           'attribute' => 'kurs.user.fullname',
           'label' => "Kurs muallifi",

       ],
       [
         'label' => "Kategoriya",
         'value' => $enroll->kurs->category->title ." - ".$enroll->kurs->subCategory->title,
       ],
       [

           'label' => "Mavzular soni",
           'value' => $enroll->kurs->getActiveLessons()->count() ." ta mavzu",

       ],
       [
            'label' => "Videolar",
            'format' => 'html',
            'value' => function($model){

                return "
                            <b>Videolar soni: </b> {$model->kurs->videosCount} <br>
                            <b>Davomiyligi: </b>   &nbsp;&nbsp;{$model->kurs->formattedVideosDuration}
                        ";

            }

       ],
       [
            'attribute' => 'created_at',
            'format' => "dateUz",
            'label' => "A'zo bo'lgan sana"
        ],

        [
            'attribute' => 'end_at',
            'format' => "dateUz",
            'label' => "A'zolikning tugash sanasi"
        ],

    ]
])

?>
