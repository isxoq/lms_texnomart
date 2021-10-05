<?php


namespace frontend\modules\profile\controllers;

use frontend\components\UserHistoryBehavior;
use frontend\modules\teacher\models\File;
use Yii;
use frontend\modules\teacher\models\Kurs;
use frontend\modules\teacher\models\Lesson;
use frontend\modules\teacher\models\Section;
use backend\modules\kursmanager\models\Enroll;
use soft\web\SController;
use yii\caching\TagDependency;
use yii\filters\AccessControl;

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
 *  - Yii::$app->view->params['_nextLessonId'] - integer - oldingi mavzu id qiymati
 *  - Yii::$app->view->params['_nextLessonTitle'] - string - oldingi mavzu title qiymati
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
 * @property-write Lesson $activeLessonData
 * @property-write array $prevLessonData
 */
class StartController extends SController
{

    public $layout = 'start_main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            UserHistoryBehavior::class,
        ];
    }

    /**
     * @param string $id Kurs id
     * @return string
     */
    public function actionIndex($id = '')
    {
        $kurs = $this->findKurs($id);
        $enroll = $this->findEnroll($id);
        $this->session->remove('_activeLessonData');
        $this->session->remove('_nextLessonData');
        $sections = $this->findActiveSections($kurs->id);
        $this->prepareLessons($kurs, $sections);
        return $this->render('lessonView');

    }

    public function actionLesson($id = '')
    {

        $lesson = $this->findLesson($id);

        $section = $this->findSection($lesson->section_id);
        $kurs = $this->findKurs($section->kurs_id);
        $this->findEnroll($kurs->id);

        $this->session->remove('_activeLessonData');

        $sections = $this->findActiveSections($kurs->id);
        $this->prepareLessons($kurs, $sections, $lesson);
        $kurs->updateLastLesson($lesson->id);
        return $this->render('lessonView');
    }

    /**
     * @param string $id
     * @return yii\console\Response|\yii\web\Response
     * @throws yii\web\ForbiddenHttpException
     * @throws yii\web\NotFoundHttpException|\Throwable
     */
    public function actionDownloadFile($id = '')
    {

        /** @var File $file */
        $file = File::findModel($id);
        $lesson = $file->lesson;
        if ($lesson == null || !$lesson->isOpen) {
            forbidden('Bu mavzuga hali yetib kelmadingiz. Oldingi darslarni bajaring!');
        }
        $section = $this->findSection($lesson->section_id);
        $kurs = $this->findKurs($section->kurs_id);
        $enroll = $this->findEnroll($kurs->id);

        if ($file->hasFile) {
            return Yii::$app->response->sendFile($file->filePath, $file->lesson->title . ' - ' . $file->title . ' (virtualdars.uz).' . $file->extension);
        } else {
            not_found('This application has not a file!');
        }

    }


    /**
     * @param $id string Kurs id
     * @return Enroll
     * @throws yii\web\ForbiddenHttpException
     */
    private function findEnroll($id = '')
    {

        $enroll = Enroll::findOne(['kurs_id' => $id, 'user_id' => user('id')]);

        if ($enroll == null) {
            // todo siz bu kursga a'zo bo'lmagansiz
            forbidden("siz bu kursga a'zo bo'lmagansiz");
        } else {

            if (!$enroll->status)

                if ($enroll->isExpired) {
                    forbidden("Ushbu kursga a'zolik vaqti tugagan"); // TODO:  must do smth if enroll is expired
                }
            return $enroll;
        }
    }

    /**
     * @param string $id
     * @return Kurs
     * @throws yii\web\NotFoundHttpException|\Throwable
     */
    private function findKurs($id = '')
    {
        $kurs = Yii::$app->db->cache(function ($db) use ($id) {
            return Kurs::find()->id($id)->one();
        }, null, new TagDependency(['tags' => 'kurs']));
        if ($kurs == null) {
            not_found();
        } else {
            $this->view->params['_activeKurs']['title'] = $kurs->title;
            return $kurs;
        }
    }

    /**
     * Finds active lesson
     * @param string $id Lesson id
     * @return Lesson
     * @throws \yii\web\NotFoundHttpException
     */
    private function findLesson($id = '')
    {
        $lesson = Yii::$app->db->cache(function ($db) use ($id) {
            return Lesson::find()->active()->id($id)->one();
        });
        if ($lesson == null) {
            not_found();
        } else {
            return $lesson;
        }
    }

    /**
     * Finds active section
     * @param string $id Section id
     * @return Section
     * @throws \yii\web\NotFoundHttpException
     */
    private function findSection($id = '')
    {
        $section = Section::find()->active()->id($id)->one();
        if ($section == null) {
            not_found();
        } else {
            $this->view->params['activeSectionId'] = $section->id;
            return $section;
        }
    }

    /**
     * @param $kurs Kurs
     * @param $sections
     * @param null $activeLesson
     * @throws \yii\web\ForbiddenHttpException
     */
    private function prepareLessons($kurs, $sections, $activeLesson = null)
    {

        if (empty($sections)) {
            forbidden('Ushbu kursda mavzular topilmadi!');
        }
        if ($activeLesson == null) {
            $activeLesson = $kurs->lastSeenLesson;
            if ($activeLesson == null) {
                if (isset($sections[0]['activeLessons'][0])) {
                    $activeLesson = Lesson::findOne($sections[0]['activeLessons'][0]['id']);
                }
            }
            if ($activeLesson == null) {
                forbidden('Ushbu kursda mavzular topilmadi!');
            }
        }

        Yii::$app->view->params['_activeSectionId'] = $activeLesson->section_id;
        Yii::$app->view->params['_activeSectionTitle'] = $activeLesson->section->title;

        $activeLesson->open();
        $this->setActiveLessonData($activeLesson);

        $nextLesson = null;
        $prevLesson = null;

        /** This loop for finding next and prev lessons */

        foreach ($sections as $sectionKey => $section) {

            $activeLessons = $section['activeLessons'];

            if ($section['id'] == $activeLesson->section_id) {
                foreach ($activeLessons as $lessonKey => $lesson) {
                    if ($lesson['id'] == $activeLesson->id) {

                        /** Find next lesson */
                        if (isset($activeLessons[$lessonKey + 1])) {
                            $nextLesson = $activeLessons[$lessonKey + 1];
                        } else {
                            if (isset($sections[$sectionKey + 1])) {
                                if (isset($sections[$sectionKey + 1]['activeLessons'][0])) {
                                    $nextLesson = $sections[$sectionKey + 1]['activeLessons'][0];
                                }
                            }
                        }

                        /** Find prev lesson */
                        if (isset($activeLessons[$lessonKey - 1])) {
                            $prevLesson = $activeLessons[$lessonKey - 1];
                        } else {
                            if (isset($sections[$sectionKey - 1])) {
                                $countLessons = count($sections[$sectionKey - 1]['activeLessons']);
                                if ($sectionKey > 0 && isset($sections[$sectionKey - 1]['activeLessons'][$countLessons - 1])) {
                                    $prevLesson = $sections[$sectionKey - 1]['activeLessons'][$countLessons - 1];
                                }
                            }
                        }
                        break;
                    }
                }
            }
        }

        if ($prevLesson != null) {
            $this->setPrevLessonData($prevLesson);
        }
        if ($nextLesson != null) {
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
            ->active()
            ->andWhere(['kurs_id' => $kurs_id])
            ->with(['activeLessons' => function ($query) {

                return $query->joinWith('section', false)
                    ->orderBy(['section.sort' => SORT_ASC, 'lesson.sort' => SORT_ASC])
                    ->with(['userLearnedLesson' => function ($q) {
                        $q->select('id,lesson_id,user_id,is_completed,watched_seconds')->asArray();
                    }]);

            }])
            ->asArray()
            ->all();

        foreach ($sections as $key => $section) {
            if (empty($section['activeLessons'])) {
                unset($sections[$key]);
            }
        }

        if (empty($sections)) {
            not_found('Ushbu kursda faol mavzular topilmadi!');
        }

        $firstLesson = $sections[0]['activeLessons'][0];
        $lessonModel = Lesson::findOne($firstLesson['id']);
        if ($lessonModel != null) {
            $lessonModel->open();
            $sections[0]['activeLessons'][0]['is_open'] = 1;
        }

        Yii::$app->view->params['_activeSections'] = $sections;
        return $sections;

    }

    /**
     * @param $lesson Lesson
     */
    private function setActiveLessonData($lesson)
    {
        Yii::$app->view->params['_activeLesson'] = $lesson;

        Yii::$app->session->set('_activeLessonData', [

            'id' => $lesson->id,
            'title' => $lesson->title,
            'media_duration' => $lesson->media_duration,
            'isCompleted' => $lesson->isCompleted,

        ]);
    }

    private function setNextLessonData($nextLesson)
    {
        Yii::$app->view->params['_nextLessonId'] = $nextLesson['id'];
        Yii::$app->view->params['_nextLessonTitle'] = $nextLesson['title'];
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