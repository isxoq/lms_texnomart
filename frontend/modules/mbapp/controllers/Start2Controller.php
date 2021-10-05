<?php

namespace frontend\modules\mbapp\controllers;

use Yii;
use frontend\components\UserHistoryBehavior;
use backend\modules\kursmanager\models\Enroll;
use frontend\modules\teacher\models\Kurs;
use frontend\modules\teacher\models\Lesson;
use frontend\modules\teacher\models\Section;
use yii\helpers\ArrayHelper;

class Start2Controller extends DefaultController
{

    /**
     * @var array Contains below elements:
     *
     *  - `course` - Kurs object
     *  - `sections`  - array - List of active Section objects. Every section includes active Lesson objects.
     *  - `activeLesson` - Lesson object
     */
    public $data = [];

    /**
     * @var array Contains below elements:
     *
     *  - `course` - Kurs object
     *  - `sections` - array - List of active Section objects. Every section includes active Lesson objects as array.
     *  - `firstLesson` - array
     *  - `activeLesson` - Lesson object
     *
     */
    public $result = [];

    //<editor-fold desc="Check User" defaultstate="collapsed">

    public function behaviors()
    {
        return [
            [
                'class' => UserHistoryBehavior::class,
                'isApp' => true,
            ]
        ];
    }

    public function actionIndex()
    {
        $this->response->format = 'json';

        if (is_guest()) {
            return $this->userNotFoundError();
        }

        $id = $this->request->get('id');
        $kurs = $this->findKurs($id);
        if ($kurs == null) {
            return $this->error('Kurs topilmadi');
        }
        $enroll = $this->findEnroll($id);
        if ($enroll == null) {
            return $this->error("Siz bu kursga a'zo bo'lmagansiz");
        }
        if ($enroll->isExpired) {
            return $this->error('Ushbu kursga a\'zolik muddati tugagan');
        }

        $sections = $this->findActiveSections();
        if (empty($sections)) {
            return $this->error('No active sections found');
        }

        $this->findActiveLesson();
        $this->prepareResult();

        return $this->success($this->result);

    }

    public function actionLesson()
    {

        $this->response->format = 'json';
        if (is_guest()) {
            return $this->userNotFoundError();
        }
        $id = $this->request->get('id');
        $lesson = $this->findLesson($id);
        if ($lesson == null) {
            return $this->error('Lesson not found!');
        }

        $kurs = $lesson->kurs;
        if ($kurs == null) {
            return $this->error('Kurs topilmadi');
        }
        $enroll = $this->findEnroll($kurs->id);
        if ($enroll == null) {
            return $this->error("Siz bu kursga a'zo bo'lmagansiz");
        }
        if ($enroll->isExpired) {
            return $this->error('Ushbu kursga a\'zolik muddati tugagan');
        }

        $this->data['course'] = $kurs;
        $sections = $this->findActiveSections();
        if (empty($sections)) {
            return $this->error('No active sections found');
        }

        $this->findActiveLesson();
        $this->prepareResult();

        $kurs->updateLastLesson($lesson->id);

        return $this->success($this->result);
    }

    //<editor-fold desc="Prepare data" defaultstate="collapsed">

    /**
     * @param string $id
     * @return Kurs
     */
    private function findKurs($id = '')
    {
        $kurs = Kurs::find()->andWhere(['id' => $id])->one();
        $this->data['course'] = $kurs;
        return $kurs;
    }

    /**
     * @param $id string Kurs id
     * @return Enroll
     */
    private function findEnroll($id = '')
    {
        return Enroll::findOne(['kurs_id' => $id, 'user_id' => Yii::$app->user->identity->id]);
    }

    /**
     * Kurs ichidagi active sectionlar va uning ichida active lessonlarni tartib bo'yicha topish
     * @return array
     */
    private function findActiveSections()
    {
        $kurs = $this->data['course'];
        $sections = Section::find()
            ->active()
            ->andWhere(['kurs_id' => $kurs->id])
            ->with(['activeLessons' => function ($query) {

                return $query->joinWith('section', false)
                    ->orderBy(['section.sort' => SORT_ASC, 'lesson.sort' => SORT_ASC])
                    ->with(['userLearnedLesson' => function ($q) {
                        $q->select('id,lesson_id,user_id');
                    }]);

            }])
            ->all();

        foreach ($sections as $key => $section) {
            if (empty($section['activeLessons'])) {
                unset($sections[$key]);
            }
        }
        $this->data['sections'] = $sections;
        return $sections;

    }

    private function findActiveLesson()
    {
        $activeLesson = ArrayHelper::getValue($this->data, 'activeLesson');
        if ($activeLesson == null) {

            $kurs = $this->data['course'];
            $activeLesson = $kurs->lastSeenLesson;
            if ($activeLesson == null) {
                $activeLesson = $this->findFirstLesson();
            }
            $this->data['activeLesson'] = $activeLesson;
        }
        $activeLesson->open();
    }

    private function findFirstLesson()
    {
        $sections = $this->data['sections'];
        /** @var Lesson $firstLesson */
        $firstLesson = $sections[0]->activeLessons[0];
        $firstLesson->open();
        return $firstLesson;
    }

    /**
     * Finds active lesson
     * @param string $id Lesson id
     * @return Lesson
     */
    private function findLesson($id = '')
    {
        $lesson = Lesson::find()->active()->id($id)->one();
        $this->data['activeLesson'] = $lesson;
        return $lesson;
    }


    //</editor-fold>

    //<editor-fold desc="Prepare result for response" defaultstate="collapsed">


    private function prepareResult()
    {
        $this->kursResult();
        $this->activeLessonResult();
        $this->sectionsResult();
    }

    private function kursResult()
    {
        /** @var Kurs $kurs */
        $kurs = $this->data['course'];
        $this->result['course_id'] = $kurs->id;
        $this->result['course_title'] = $kurs->title;

        $activeLessonsCount = $kurs->activeLessonsCount;
        $completedLessonsCount = $kurs->completedLessonsCount;

        if ($activeLessonsCount == 0) {
            $completedPercent = 0;
        } else {
            $completedPercent = intval($completedLessonsCount / $activeLessonsCount * 100);
        }

        $this->result['totalCoursesCount'] = $activeLessonsCount;
        $this->result['completedLessonsCount'] = $completedLessonsCount;
        $this->result['completedPercent'] = $completedPercent;

    }

    private function activeLessonResult()
    {
        /** @var Lesson $lesson */
        $lesson = $this->data['activeLesson'];
        $result = [
            'id' => $lesson->id,
            'title' => $lesson->title,
            'description' => $lesson->description,
            'media_stream_src' => $lesson->media_stream_src,
            'isCompleted' => $lesson->isCompleted,
            'mediaDuration' => $lesson->formattedDuration,
            'type' => $lesson->type,
            'startTime' => $lesson->startTime,
            'hasStreamedVideo' => $lesson->hasStreamedVideo,
        ];

        $this->result['activeLesson'] = $result;
    }

    private function sectionsResult()
    {
        /** @var Section[] $sections */
        $sections = $this->data['sections'];

        $result = [];

        foreach ($sections as $section) {
            $sectionItem = $this->singleSectionResult($section);
            $sectionItem['lessons'] = $this->lessonsResult($section->activeLessons);
            $result[] = $sectionItem;
        }
        $this->result['sections'] = $result;
    }

    /**
     * @param $section Section
     * @return array
     */
    private function singleSectionResult($section)
    {
        return [
            'id' => $section->id,
            'title' => $section->title,
        ];
    }

    /**
     * @param $lessons Lesson[]
     * @return array
     */
    private function lessonsResult($lessons)
    {
        $result = [];
        foreach ($lessons as $lesson) {
            $result[] = $this->singleLessonResult($lesson);
        }
        return $result;
    }

    /**
     * @param $lesson Lesson
     * @return array
     */
    private function singleLessonResult($lesson)
    {
        return [
            'id' => $lesson->id,
            'title' => $lesson->title,
            'type' => $lesson->type,
            'mediaDuration' => $lesson->formattedDuration,
        ];
    }

    //</editor-fold>

}