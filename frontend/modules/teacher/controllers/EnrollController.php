<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.04.2021, 14:28
 */

namespace frontend\modules\teacher\controllers;

use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\LearnedLesson;
use backend\modules\kursmanager\models\search\LearnedLessonSearch;
use frontend\components\UserHistoryBehavior;
use soft\web\SController;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class EnrollController
 * @package frontend\modules\teacher\controllers
 */
class EnrollController extends SController
{

    public function behaviors()
    {
        return[
            UserHistoryBehavior::class,
        ];
    }

    /**
     * @param $id int Enroll id raqami
     */
    public function actionLessonsInfo($id)
    {
        $enroll = Enroll::findOne($id);
        if (!$enroll) {
            not_found();
        }
        $kurs = $enroll->kurs;
        if ($kurs->user_id != user('id')) {
            forbidden();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $kurs->getActiveLessons()->with('section'),
        ]);
        return $this->render('lessonsInfo', [

            'enroll' => $enroll,
            'kurs' => $kurs,
            'dataProvider' => $dataProvider,

        ]);

    }

}