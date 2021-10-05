<?php


namespace frontend\modules\profile\controllers;

use Yii;
use backend\modules\kursmanager\models\LearnedLesson;
use frontend\modules\teacher\models\Lesson;
use soft\web\SController;
use yii\filters\VerbFilter;

class WatchController extends SController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'save-watch' => ['POST'],
                ],
            ],

        ];
    }

    public function actionSaveWatch($lesson_id = '')
    {
        if (!$this->isAjax) {
            return 'is not ajax';
        }
        /** @var Lesson $activeLesson */

        $activeLessonData = $this->session->get('_activeLessonData');
        if ($lesson_id != $activeLessonData['id']) {
            return 'lesson id does not match';
        }
        if($this->saveWatch($activeLessonData)){
            return 'success';
        }
        else{
            return 'error on saving';
        }
    }


    /**
     * @param array $activeLessonData
     * @return false
     */
    private function saveWatch($activeLessonData)
    {

        $user_id = user('id');
        $lesson_id = $activeLessonData['id'];

        $model = LearnedLesson::findOne([
            'lesson_id' => $lesson_id,
            'user_id' => $user_id
        ]);

        if ($model == null) {
            $model = new LearnedLesson([
                'lesson_id' => $lesson_id,
                'user_id' => $user_id,
                'watched_seconds' => 0,
                'is_completed' => 0,
            ]);
        }

        $interval = Yii::$app->site->updateWatchInterval;
        $model->watched_seconds += $interval;
        $mediaDuration = $activeLessonData['media_duration'];
        if ($mediaDuration > 0 && $model->watched_seconds > $mediaDuration) {
            $model->watched_seconds = $mediaDuration;
        }
        $model->current_time = intval($this->post('currentTime'));
        if ($model->current_time < 0) {
            $model->current_time = 0;
        }

        if (!$model->is_completed) {
            if ($this->checkIfLessonHasBeenCompleted($mediaDuration, $model->watched_seconds)) {
                $model->is_completed = 1;
            }
        }

        return $model->save();
    }

    /**
     * @param $lesson_duration
     * @param $watched_seconds
     * @return bool
     */
    private function checkIfLessonHasBeenCompleted($lesson_duration, $watched_seconds)
    {
        $duration = intval($lesson_duration);
        if ($duration <= 0) {
            return true;
        }
        $percent = intval($watched_seconds / $duration * 100);

        return $percent >= Yii::$app->site->percentForCompleteLesson;
    }


}