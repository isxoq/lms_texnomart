<?php


namespace frontend\modules\mbapp\controllers;

use frontend\components\UserHistoryBehavior;
use Yii;
use backend\modules\kursmanager\models\LearnedLesson;
use frontend\modules\teacher\models\Lesson;

class WatchController extends DefaultController
{

    public $nextLessonIsOpened = false;
    public $nextLessonId = '';
    public $watchedSeconds = 0;
    public $errorMessage = '';


    public function behaviors()
    {
        return [
            [
                'class' => UserHistoryBehavior::class,
                'isApp' => true,
            ]
        ];
    }


    public function actionLesson()
    {
        if (is_guest()) {
            return $this->userNotFoundError();
        }

        $lessonId = $this->request->post('lessonId');

        if ($lessonId == null) {
            return $this->error('Lesson not found');
        }

        $lesson = $this->findLesson($lessonId);

        if ($lesson == null) {
            return $this->error('Lesson not found');
        }

        if ($this->saveWatch($lesson)) {
            $this->checkIfLessonIsCompleted($lesson);
        } else {
            return $this->error("Saqlashda xatolik yuz berdi!");
        }

        return $this->success([
            'nextLessonIsOpened' => $this->nextLessonIsOpened,
            'nextLessonId' => $this->nextLessonId,
        ]);


    }

    /**
     * Finds active lesson
     * @param string $id Lesson id
     * @return Lesson
     */
    public function findLesson($id = '')
    {
        return Yii::$app->db->cache(function ($db) use ($id) {
            return Lesson::findOne($id);
        });
    }

    /**
     * @param $lesson Lesson
     * @return bool
     */
    public function saveWatch($lesson)
    {

        $user_id = user()->id;

        $lesson_id = $lesson->id;

        $model = LearnedLesson::findOne([
            'lesson_id' => $lesson_id,
            'user_id' => $user_id
        ]);

        if ($model == null) {
            $model = new LearnedLesson([
                'lesson_id' => $lesson_id,
                'user_id' => $user_id,
                'watched_seconds' => 0
            ]);
        }


        $watchedSeconds = 10;
        $model->watched_seconds = $model->watched_seconds + $watchedSeconds;
        $mediaDuration = intval($lesson->media_duration);
        if ($mediaDuration > 0 && $model->watched_seconds > $mediaDuration) {
            $model->watched_seconds = $mediaDuration;
        }
        $model->current_time = intval($this->post('currentTime', 0));
        if ($model->current_time < 0) {
            $model->current_time = 0;
        }

        if ($model->save()) {
            $this->watchedSeconds = $model->watched_seconds;
            return true;
        } else {
            $this->errorMessage = $model->error;
            return false;
        }
    }

    /**
     * @param $lesson Lesson
     * @return bool
     */
    public function checkIfLessonIsCompleted($lesson)
    {

        if ($lesson->isCompleted) {
            return false;
        }
        if ($this->checkIfLessonHasBeenCompleted($lesson->media_duration)) {

            $lesson->complete();

            $nextLesson = $this->findNextLesson($lesson);
            if ($nextLesson != null) {

                if (!$nextLesson->isOpen) {
                    if ($nextLesson->open()) {
                        $this->nextLessonIsOpened = true;
                        $this->nextLessonId = $nextLesson->id;
                    }
                }

            }


        }

    }

    /**
     * @param $lesson_duration
     * @return bool
     */
    public function checkIfLessonHasBeenCompleted($lesson_duration)
    {
        $watched_seconds = $this->watchedSeconds;
        $duration = intval($lesson_duration);
        if ($duration <= 0) {
            return true;
        }
        $percent = intval($watched_seconds / $duration * 100);

        return $percent >= Yii::$app->site->percentForCompleteLesson;
    }

    /**
     * @param $lesson Lesson
     * @return null|Lesson
     */
    private function findNextLesson($lesson)
    {
        $kurs = $lesson->kurs;
        if ($kurs == null) {
            return null;
        }
        $activeLessons = $kurs->activeLessons;
        foreach ($activeLessons as $key => $activeLesson) {
            if ($activeLesson->id == $lesson->id) {
                if (isset($activeLessons[$key + 1])) {
                    return $activeLessons[$key + 1];
                }
            }
        }
        return null;
    }


    public function actionTest()
    {

        $user = Yii::$app->user->identity;
        if ($user == null) {
            return $this->userNotFoundError();
        }


        $lessonId = $this->post('lessonId');

        if ($lessonId == null) {
            return $this->error('Lesson not found');
        }

        $lesson = $this->findLesson($lessonId);

        if ($lesson == null) {
            return $this->error('Lesson not found');
        }

        $model = LearnedLesson::findOne([
            'lesson_id' => $lesson->id,
            'user_id' => $user->id
        ]);

        if ($model == null) {
            $model = new LearnedLesson([
                'lesson_id' => $lesson->id,
                'user_id' => $user->id,

            ]);
        }

        $watchedSeconds = intval($model->watched_seconds) + 10;
        $model->watched_seconds = $watchedSeconds;
        $mediaDuration = intval($lesson->media_duration);

        if ($mediaDuration > 0 && $model->watched_seconds > $mediaDuration) {
            $model->watched_seconds = $mediaDuration;
        }

        $model->current_time = 0;

        if ($model->save()) {
            return $this->success([
                'nextLessonIsOpened' => true,
                'nextLessonId' => intval($watchedSeconds),
            ]);
        } else {
            return $this->success([
                'nextLessonIsOpened' => false,
                'nextLessonId' => intval($model->watched_seconds),
            ]);
        }

    }

    public function actionSave()
    {
        if (is_guest()) {
            return $this->userNotFoundError();
        }

        $lessonId = $this->post('lessonId');
        if ($lessonId == null) {
            return $this->error('Lesson not found');
        }
        $lesson = $this->findLesson($lessonId);

        if ($lesson == null) {
            return $this->error('Lesson not found');
        }

        if ($this->saveWatch($lesson)) {
            $this->checkIfLessonIsCompleted($lesson);
        } else {
            return $this->error("Saqlashda xatolik yuz berdi!");
        }

        return $this->success([
            'nextLessonIsOpened' => $this->nextLessonIsOpened,
            'nextLessonId' => $this->nextLessonId,
        ]);


    }

}
