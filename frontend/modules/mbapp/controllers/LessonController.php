<?php


namespace frontend\modules\mbapp\controllers;


use frontend\components\UserHistoryBehavior;
use frontend\modules\teacher\models\Lesson;

class LessonController extends DefaultController
{

    public function behaviors()
    {
        return [
            [
                'class' => UserHistoryBehavior::class,
                'isApp' => true,
            ]
        ];
    }


    public function actionFiles()
    {

        if (is_guest()){
            return $this->userNotFoundError();
        }
        $lesson_id = $this->post('lesson_id');

        $lesson = Lesson::find()->active()->id($lesson_id)->one();
        if ($lesson == null){
            return $this->error('Mavzu topilmadi!');
        }

        $files = $lesson->getFiles()->active()->all();

        return $this->success($files);

    }

}