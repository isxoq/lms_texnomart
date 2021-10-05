<?php


namespace frontend\modules\teacher\controllers;

use frontend\components\UserHistoryBehavior;
use Yii;
use frontend\modules\teacher\models\Kurs;
use frontend\modules\teacher\models\Lesson;
use frontend\modules\teacher\models\Section;
use soft\web\SController;
use yii\caching\TagDependency;

/**
 * Class StartController - o'quvchilar tomonidan kursni o'rganish uchun actionlar
 * Kursga kirilganda quyidagi parametrlar o'rnatilishi lozim:
 *
 *  - Yii::$app->view->params['_activeLesson'] - Lesson - ayni paytdagi faol dars
 *  - $_SESSION['_activeLessonData'] - array - ayni paytdagi faol dars ma'lumotlari
 *      Quyidagilarni o'z ichiga oladi
 * * -  $_SESSION['_activeLesson']['id']
 * * -  $_SESSION['_activeLesson']['title']
 * * -  $_SESSION['_activeLesson']['media_duration']
 * * -  $_SESSION['_activeLesson']['isCompleted']
 * @see setActiveLessonData()
 *
 *  - $_SESSION['_nextLessonData'] - array - keyingi dars ma'lumotlari
 *      Quyidagilarni o'z ichiga oladi
 * * -  $_SESSION['_nextLessonData']['id']
 * * -  $_SESSION['_nextLessonData']['title']
 * * -  $_SESSION['_nextLessonData']['isOpen'] - bool - agar true bo'lsa, actionSaveWatch() da keyingi lessonni open qilish shartemas
 * @see setNextLessonData()
 *
 *  - Yii::$app->view->params['_activeKurs']['title'] - string - ayni paytdagi faol kurs nomi
 * @see findKurs()
 *
 *  - Yii::$app->view->params['_activeSectionId'] - Section - ayni paytdagi faol section id qiymati
 *  - Yii::$app->view->params['_activeSectionTitle'] - Section - ayni paytdagi faol section title qiymati
 * @see prepareLessons()
 *
 *  - Yii::$app->view->params['_prevLessonId'] - integer - oldingi mavzu id qiymati
 *  - Yii::$app->view->params['_prevLessonTitle'] - string - oldingi mavzu title qiymati
 * @see setPrevLessonData()
 *
 *  - Yii::$app->view->params['_activeSections'] - array - tarkibida active lessonlari bo'lgan, tartiblangan bo'limlar ro'yxati, chap tarafdagi sidebar uchun
 * @see findActiveSections()
 *
 * @package frontend\modules\profile\controllers
 *
 *
 * @property-write frontend\modules\teacher\models\Lesson $activeLessonData
 * @property-write array $prevLessonData
 */
class StartController extends SController
{

    public $layout = 'start/start_main';

    public function behaviors()
    {
        return [

            UserHistoryBehavior::class,

        ];
    }

    /**
     * @param string $id Kurs id
     * @return string
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($id = '')
    {

        $kurs = Kurs::findOwnModel($id);
        Yii::$app->view->params['_activeKurs']['title'] = $kurs->title;
        $sections = $this->findActiveSections($kurs->id);
        $this->prepareLessons($kurs, $sections);
        return $this->render('lessonView');

    }

    public function actionLesson($id = '')
    {

        $lesson = Lesson::findOwnModel($id);

        $section = $lesson->section;
        $sections = $this->findActiveSections($section->kurs_id);
        $kurs = $section->kurs;
        Yii::$app->view->params['_activeKurs']['title'] = $kurs->title;
        $this->prepareLessons($kurs, $sections, $lesson);

        return $this->render('lessonView');
    }

    /**
     * @param $kurs Kurs
     * @param null|string|int $activeLesson
     * @throws yii\web\ForbiddenHttpException
     */
    private function prepareLessons($kurs, $sections, $activeLesson = null)
    {

        if (empty($sections)) {
            forbidden("Ushbu kursda mavzular topilmadi!");
        }
        if ($activeLesson == null) {
              if (isset($sections[0]['lessons'][0])){
                  $activeLesson = Lesson::findOne($sections[0]['lessons'][0]['id']);
            }
            if ($activeLesson == null) {
                forbidden("Ushbu kursda mavzular topilmadi!");
            }

        }

        Yii::$app->view->params['_activeSectionId'] = $activeLesson->section_id;
        Yii::$app->view->params['_activeSectionTitle'] = $activeLesson->section->title;

        $this->setActiveLessonData($activeLesson);

        $nextLesson = null;

        /** This loop for finding next and prev lessons */

        foreach ($sections as $sectionKey => $section) {

            $lessons = $section['lessons'];

            if ($section['id'] == $activeLesson->section_id) {
                foreach ($lessons as $lessonKey => $lesson) {

                    if ($lesson['id'] == $activeLesson->id) {

                        /** Find next lesson */
                        if (isset($lessons[$lessonKey + 1])) {
                            $nextLesson = Lesson::findOne($lessons[$lessonKey + 1]['id']);
                        } else {
                            if (isset($sections[$sectionKey + 1])) {
                                if (isset($sections[$sectionKey + 1]['lessons'][0])) {
                                    $nextLesson = Lesson::findOne($sections[$sectionKey + 1]['lessons'][0]['id']);
                                }
                            }
                        }

                        /** Find prev lesson */
                        if (isset($lessons[$lessonKey - 1])) {
                            $prevLesson = $lessons[$lessonKey - 1];
                            $this->setPrevLessonData($prevLesson);
                        } else {
                            if (isset($sections[$sectionKey - 1])) {
                                $countLessons = count($sections[$sectionKey - 1]['lessons']);
                                if ( $sectionKey > 0 && isset($sections[$sectionKey - 1]['lessons'][$countLessons-1])) {
                                    $prevLesson = $sections[$sectionKey - 1]['lessons'][$countLessons-1];
                                    $this->setPrevLessonData($prevLesson);

                                }
                            }
                        }
                        break;
                    }

                }
            }

        }

        if ($nextLesson != null){
            $this->setNextLessonData($nextLesson);
        }
    }

    /**
     * Kurs ichidagi active sectionlar va uning ichida active lessonlarni tartib bo'yicha topish
     * @param $kurs_id
     * @return array
     */
    private function findActiveSections($kurs_id)
    {

        $sections = Section::find()
            ->andWhere(['kurs_id' => $kurs_id])
            ->with(['lessons' => function ($query) {

                return $query->joinWith('section', false)
                    ->orderBy(['section.sort' => SORT_ASC, 'lesson.sort' => SORT_ASC])
                    ->with(['userLearnedLesson' => function($q){
                        $q->select('id,lesson_id,user_id')->asArray();
                    }])
                    ;

            }])
            ->asArray()
            ->all();

        foreach ($sections as $key => $section) {
            if (empty($section['lessons'])) {
                unset($sections[$key]);
            }
        }

        Yii::$app->view->params['_sections'] = $sections;
        return $sections;

    }

    /**
     * @param $lesson Lesson
     */
    private function setActiveLessonData($lesson)
    {
        Yii::$app->view->params['_activeLesson'] = $lesson;
    }

    private function setNextLessonData($nextLesson, $nextLessonIsOpen = false)
    {
        Yii::$app->view->params['_nextLesson'] = $nextLesson;
    }

    /**
     * @param $prevLesson array
     * @see prepareLessons()
     */
    private function setPrevLessonData($prevLesson)
    {
        Yii::$app->view->params['_prevLessonId'] = $prevLesson['id'];
        Yii::$app->view->params['_prevLessonTitle'] = $prevLesson['title'];
    }


}