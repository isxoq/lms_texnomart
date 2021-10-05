<?php


namespace backend\modules\import\controllers;

use Yii;
use backend\modules\import\models\OldEnroll;
use backend\modules\import\models\OldSection;
use backend\modules\kursmanager\models\Enroll;
use backend\modules\kursmanager\models\LearnedLesson;
use backend\modules\kursmanager\models\Lesson;
use backend\modules\kursmanager\models\Section;
use backend\modules\import\models\OldUser;
use backend\modules\import\models\OldKurs;
use backend\modules\import\models\OldLesson;
use backend\modules\kursmanager\models\Kurs;
use backend\controllers\BackendController;
use common\models\User;
use yii\helpers\Json;


class DefaultController extends BackendController
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImportUser()
    {
        $oldUsers = OldUser::find()->all();

        $transaction = Yii::$app->db->beginTransaction();

        try {

            $flag = true;

            foreach ($oldUsers as $oldUser) {

                $user = User::findOne($oldUser->id);
                if ($user == null) {
                    $user = new User(['id' => $oldUser->id]);
                }

                $user->detachBehaviors();

                $user->username = null;
                $user->email = $oldUser->email;
                $user->status = $oldUser->status ? 10 : 0;
                $user->created_at = $oldUser->date_added;
                $user->updated_at = $oldUser->last_modified;
                $user->watch_history = $oldUser->watch_history;
                $user->wish_list = $oldUser->wishlist;
                $user->firstname = $oldUser->first_name;
                $user->lastname = $oldUser->last_name;
                $user->deleted = 0;
                $user->type = 'user';
                $user->bio = $oldUser->biography;
                $user->password_md5 = $oldUser->password;

                if (!$user->save()) {
//                    $flag = false;
//                    $transaction->rollBack();
                    dump($user->attributes);
                    dump($user->errors);
//                    break;
                }

                if ($oldUser->is_instructor == 1) {
                    try {
                        Yii::$app->admin->approveTeacher($user);
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        $flag = false;
                        dd($e);
                    }

                }

            }

            if ($flag) {
                $transaction->commit();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            dd($e);
        }

        return $this->redirect('index');

    }

    public function actionImportCourse()
    {

        $oldCourses = OldKurs::find()->all();
        $transaction = Yii::$app->db->beginTransaction();

        try {

            $flag = true;

            foreach ($oldCourses as $oldCourse) {


                $kurs = Kurs::findOne($oldCourse->id);

                if ($kurs == null) {
                    $kurs = new Kurs(['id' => $oldCourse->id]);
                }

                $kurs->id = $oldCourse->id;
                $kurs->title = $oldCourse->title;
                $kurs->short_description = $oldCourse->short_description;
                $kurs->description = $oldCourse->description;
                $kurs->category_id = $oldCourse->sub_category_id;
                $kurs->level = $oldCourse->level;
                $kurs->user_id = $oldCourse->findUserId();
                $kurs->is_best = $oldCourse->is_top_course;
                $kurs->is_free = $oldCourse->is_free_course;
                $kurs->preview_host = $oldCourse->course_overview_provider;
                $kurs->preview_link = $oldCourse->video_url;
                $kurs->language = substr($oldCourse->language, 0, 2);
                $kurs->image = "/uploads/course/course_thumbnail_default_" . $oldCourse->id . '.jpg';
                $kurs->meta_keywords = $oldCourse->meta_keywords;
                $kurs->meta_description = $oldCourse->meta_description;
                $kurs->created_at = $oldCourse->date_added;
                $kurs->updated_at = $oldCourse->last_modified;
                $kurs->status = $oldCourse->status == 'active' ? 1 : 5;
                $kurs->deleted = 0;
                $kurs->benefits = $oldCourse->benefits();
                $kurs->requirements = $oldCourse->requirements();

                $kurs = $oldCourse->getPrices($kurs);

                if (!$kurs->save()) {
                    $flag = false;
                    echo $oldCourse->id . "\n";
                    echo $oldCourse->user_id;
                    dump($kurs->errors);
                    $transaction->rollBack();
                    break;
                }
            }
            if ($flag) {
                $transaction->commit();
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            dd($e);
        }

        return $this->redirect('index');

    }

    public function actionImportSection()
    {

        $oldSections = OldSection::find()->all();
        $transaction = Yii::$app->db->beginTransaction();

        try {

            $flag = true;

            foreach ($oldSections as $oldSection) {


                $section = Section::findOne($oldSection->id);

                if ($section == null) {
                    $section = new Section(['id' => $oldSection->id]);
                }

                $section->title = $oldSection->title;
                $section->kurs_id = $oldSection->course_id;
                $section->sort = $oldSection->order;
                $section->status = 1;

                if (!$section->save()) {
//                    $flag = false;
                    dump($oldSection->attributes);
                    dump($section->errors);
//                    $transaction->rollBack();
//                    break;
                }
            }
            if ($flag) {
                $transaction->commit();
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            dd($e);
        }

        return $this->redirect('index');

    }

    public function actionImportLesson()
    {

        $oldLessons = OldLesson::find()->all();
        $transaction = Yii::$app->db->beginTransaction();

        try {

            $flag = true;

            foreach ($oldLessons as $oldLesson) {


                $lesson = Lesson::findOne($oldLesson->id);

                if ($lesson == null) {
                    $lesson = new Lesson(['id' => $oldLesson->id]);
                }

                $lesson->section_id = $oldLesson->section_id;
                $lesson->title = $oldLesson->title;
                $lesson->sort = $oldLesson->order;
                $lesson->status = 1;
                $lesson->created_at = $oldLesson->date_added;
                $lesson->updated_at = $oldLesson->last_modified;
                $lesson->conclusion = $oldLesson->summary;

                if (!$lesson->save()) {
//                    $flag = false;
                    dump($oldLesson->attributes);
                    dump($lesson->errors);
//                    $transaction->rollBack();
//                    break;
                }
            }
            if ($flag) {
                $transaction->commit();
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            dd($e);
        }

        return $this->redirect('index');

    }

    public function actionImportEnroll()
    {

        Enroll::deleteAll();
        $oldEnrolls = OldEnroll::find()->all();

        $endAt = strtotime("01-01-2023");

        foreach ($oldEnrolls as $oldEnroll){


            $enroll = Enroll::findOne([

                'kurs_id' => $oldEnroll->course_id,
                'user_id' => $oldEnroll->user_id,

            ]);


            if ($enroll == null){

                $enroll = new Enroll([

                    'kurs_id' => $oldEnroll->course_id,
                    'user_id' => $oldEnroll->user_id,

                ]);
            }

            $enroll->created_at = $oldEnroll->date_added;
            $enroll->end_at = $endAt;
            if(!$enroll->save()){
                dump($enroll->errors);
            }

        }

        return $this->redirect('index');

    }

    public function actionUpdateKursEnrollsCount()
    {

        $kurses = Kurs::find()->with('enrolls')->all();

        foreach ($kurses as $kurs){

            $kurs->scenario = 'updateEnrollsCount';
            $kurs->enrolls_count = count($kurs->enrolls);
            $kurs->save();

        }

        return $this->redirect('index');

    }

    public function actionNormalizeSections()
    {

        $sections = Section::find()->andWhere(['like', 'title',  "&#039;"])->all();

        foreach ($sections as $section){

            $section->title = str_replace('&#039;', "'", $section->title);
            $section->save();

        }

        return $this->redirect('index');
    }

    public function actionNormalizeLessons()
    {

        $lessons = Lesson::find()->andWhere(['like', 'title',  "&#039;"])->all();

        foreach ($lessons as $lesson){

            $lesson->title = str_replace('&#039;', "'", $lesson->title);
            $lesson->save();

        }
        return $this->redirect('index');

    }


    public function actionDeleteLearnedLessons()
    {

        LearnedLesson::deleteAll();
        return $this->redirect('index');

    }

    public function actionOpenLessons()
    {
        ini_set('memory_limit', -1);
        set_time_limit(0);
        $users = User::find()->where(['>','id', 274])->all();

        foreach ($users as $user){

            $watchHistory = $user->watch_history;

            if (!empty($watchHistory)){

                $watches = Json::decode($watchHistory);

                if (!empty($watches) && is_array($watches)){

                    foreach ($watches as $watch){

                        $learnedLesson = new LearnedLesson([
                            'user_id' => $user->id,
                            'lesson_id' => $watch['lesson_id'],
                            'is_completed' => 1,
                        ]);

                        $learnedLesson->save();

                    }

                }

            }

        }
    }

    public function actionOpenAllLessons()
    {
        ini_set('memory_limit', -1);
        set_time_limit(0);

        $courses = Kurs::getAll();

        foreach ($courses as $course){

            $users = $course->enrolledUsers;

            $lessons = $course->lessons;

            foreach ($users as $user){

                foreach ($lessons as $lesson) {

                    $learnedLesson = LearnedLesson::findOne([
                        'user_id' => $user->id,
                        'lesson_id' => $lesson->id,
                    ]);
                    if($learnedLesson == null){

                        $learnedLesson = new LearnedLesson([
                            'user_id' => $user->id,
                            'lesson_id' => $lesson->id,

                        ]);

                    }

                    $learnedLesson->is_completed = 1;

                    $learnedLesson->save();

                }
                
            }

        }
    }

}