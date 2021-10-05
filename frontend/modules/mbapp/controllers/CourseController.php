<?php


namespace frontend\modules\mbapp\controllers;

use frontend\components\UserHistoryBehavior;
use frontend\modules\mbapp\models\Kurs;
use Yii;

class CourseController extends DefaultController
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


    public function actionAll()
    {
        $search = $this->request->get('search');
        return $this->success(Kurs::allCourses($search));
    }

    public function actionPopularCourses($limit = 6)
    {
        $bestCourses = Kurs::bestCourses($limit);
        $courses = [];
        foreach ($bestCourses as $bestCours) {
            $course = $bestCours->toArray();
            $courses[] = $course;
        }

        return $this->success($courses);
    }

    public function actionDetail($id = '')
    {
        $model = Kurs::findActiveOne($id);
        if ($model == null) {
            return $this->error("Kurs topilmadi!");
        }
        $model->fields = [
            'id',
            'slug',
            'title',
            'short_description',
            'description',
            'is_free',
            'price',
            'formattedPrice',
            'hasDiscount',
            'old_price',
            'formattedOldPrice',
            'youtube',
            'video_link' => 'formattedVideLink',
            'image' => 'kursImage',
            'rating' => 'averageRating',
            'ratingsCount',
            'user_id',
            'benefits' => 'benefitsAsArray',
            'requirements' => 'requirementsAsArray',
            'includes',
            'students' => 'enrolls_count',
            'videoDuration' => 'formattedActiveLessonsDuration',
            'lessonsCount' => 'activeLessonsCount',
            'sections',
            'isWished',
            'isEnrolled' => 'userHasActiveEnroll',
        ];
        return $this->success($model);
    }

    public function actionOfflinePayment()
    {
        $info = settings('site', 'offline_payment_info');
        return $this->success($info);
    }

}