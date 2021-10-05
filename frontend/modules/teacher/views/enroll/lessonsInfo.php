<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.04.2021, 14:49
 */

use backend\modules\kursmanager\models\search\LearnedLessonSearch;
use backend\modules\kursmanager\models\LearnedLesson;
use backend\modules\kursmanager\models\Lesson;

/* @var $this \yii\web\View */
/* @var $enroll \backend\modules\kursmanager\models\Enroll|null */
/* @var $kurs \backend\modules\kursmanager\models\Kurs */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $kurs->title, 'url' => ['kurs/view', 'id' => $kurs->id]];
$this->params['breadcrumbs'][] = ['label' => "A'zo bo'lganlar", 'url' => ['kurs/students', 'id' => $kurs->id]];
$this->params['breadcrumbs'][] = $enroll->user->fullname;

$this->title = "Ko'rilgan mavzular";

?>

<?= \soft\adminty\GridView::widget([

    'dataProvider' => $dataProvider,
    'cols' => [
        [

            'attribute' => 'lessonTitle',
            'value' => function ($model) {
                /** @var Lesson $model */
                return $model->title;
            },
            'label' => 'Mavzu'

        ],
        [

            'label' => "Ko'rildi",
            'format'=>'raw',
            'width' => '100px',
            'value' => function($model) use ($enroll){

                /** @var Lesson $model */
                $learnedLesson = $model->getLearnedLessonByUserId($enroll->user_id);

                if (!$learnedLesson){
                    return "<i class='fa fa-lock'></i>";
                }

                return $learnedLesson->getStatusIcon() . ' ' . $learnedLesson->watchedPercent;
            }

        ],

//        [
//
//            'label' => "Holat",
//            'format'=>'raw',
//            'value' => function($model){
//                /** @var LearnedLesson $model */
//                return $model->statusIcon;
//            }
//
//        ],

        [

            'attribute' => 'section_id',
            'value' => function ($model) {
                /** @var Lesson $model */
                return $model->section->title;
            },
//            'filter' => $sectionsArray,
            'label' => "Bo'lim"

        ],
    ]

]) ?>
