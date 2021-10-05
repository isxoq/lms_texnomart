<?php

namespace frontend\modules\mbapp\controllers;

use backend\modules\kursmanager\models\Enroll;
use common\models\User;
use frontend\components\UserHistoryBehavior;
use frontend\modules\mbapp\models\Kurs;
use Yii;

class UserController extends DefaultController
{

    public function behaviors()
    {
        return [
            [
                'class' => UserHistoryBehavior::class,
                'isApp' => true,
                'excludeActions' => ['check-token']
            ]
        ];
    }


    /**
     * Bazada shu token bor yoki yo'qligini tekshirish
     * token headerda keladi
     * @return array
     */
    public function actionCheckToken()
    {
        if (is_guest()){
            return $this->error();
        }
        else{
            return $this->success();
        }
    }

    public function actionMyCourses()
    {
        if (is_guest()) {
            return $this->error('Foydalanuvchi topilmadi');
        }
        /** @var \frontend\models\Kurs[] $courses */
        $courses = Yii::$app->user->identity->activeEnrolledCourses;
        if (empty($courses)) {
            $courses = [];
            return $this->success($courses);
        }

        $result = [];
        foreach ($courses as $course) {

            if (!$course->userEnroll->isExpired) {

                $item = $course->toArray();

                $activeLessonsCount = $course->activeLessonsCount;
                $completedLessonsCount = $course->completedLessonsCount;

                if ($activeLessonsCount == 0) {
                    $completedPercent = 0;
                } else {
                    $completedPercent = intval($completedLessonsCount / $activeLessonsCount * 100);
                }

                $item['totalCoursesCount'] = $activeLessonsCount;
                $item['completedLessonsCount'] = $completedLessonsCount;
                $item['completedPercent'] = $completedPercent;
                $item['image'] = $course->kursImage;
                $item['rating'] = floatval($course->averageRating);

                $result[] = $item;
            }

        }

        return $this->success($result);
    }

    /**
     * Kursni wish listga qo'shish yoki olib yashlash
     * @return array
     */
    public function actionWish()
    {

        if (is_guest()) {
            return $this->userNotFoundError();
        }

        $id = Yii::$app->request->get('id');
        $result = [
            'success' => false,
            'action' => 'no-action',
            'message' => false
        ];

        if ($id == null) {
            return $result;
        }

        $user = Yii::$app->user->identity;

        if (!$user->isWish($id)) {
            if ($user->addToWishList($id)) {
                $result['success'] = true;
                $result['action'] = 'added';
                $result['message'] = t('Added to wishlist');
            }
        } else {
            if ($user->removeFromWishList($id)) {
                $result['success'] = true;
                $result['action'] = 'removed';
                $result['message'] = t('Removed from wishlist');
            }
        }

        return $result;
    }

    /**
     * @return \frontend\modules\teacher\models\Kurs[]
     */
    public function actionMyFavouriteCourses()
    {
        if (is_guest()) {
            return $this->error('Foydalanuvchi topilmadi');
        }
        $wishlist = Kurs::find()->andWhere(['in', 'id', Yii::$app->user->identity->wishListAsArray])->active()->all();
        if (empty($wishlist)) {
            $wishlist = [];
            return $this->success($wishlist);
        }
        return $this->success($wishlist);
    }

    /**
     * @return \frontend\modules\teacher\models\Kurs[]
     */
    public function actionUpdatePersonalData()
    {
        if (is_guest()) {
            return $this->userNotFoundError();
        }

        $user = user();
        $user->scenario = 'updatePersonalData';
        $user->firstname = $this->post('firstname');
        $user->lastname = $this->post('lastname');
        if ($user->save()){
            return $this->success();
        }
        else{
            return $this->error($user->error);
        }

    }

    public function actionChangePassword()
    {
        if (is_guest()) {
            return $this->userNotFoundError();
        }

        $user = user();

        $currentPasssword = $this->post('current_password');

        if (empty($currentPasssword)){
            return $this->error('Joriy parolni kiriting');
        }

        if (!Yii::$app->security->validatePassword($currentPasssword, $user->password_hash)){
            return $this->error('Joriy parol mos kelmayapti');
        }

        $password = $this->post('password');
        if (strlen($password) < 5){
            return $this->error("Parol kamida 5 ta belgidan iborat bo'lishi kerak");
        }

        $user->password_hash = Yii::$app->security->generatePasswordHash($password);

        if ($user->save(false)){
            return $this->success(t('Your password has been changed successfully'));
        }
        else{
            return $this->error();
        }

    }
    
    public function actionFreeEnroll()
    {


        if (is_guest()){
            return $this->userNotFoundError();
        }

        $id = $this->post('course_id');

        $model = \frontend\models\Kurs::find()->active()->andWhere(['kurs.id' => $id])->one();

        if ($model == null) {
            return $this->error('Kurs topilmadi');
        }

        if (!$model->is_free) {
            return $this->error("Ushbu kursga a'zo bo'lish uchun kursni sotib olishingiz zarur");
        }

        $user_id = user('id');

        $enroll = Enroll::findOne(['user_id' => $user_id, 'kurs_id' => $model->id]);

        if ($enroll == null) {

            if (Yii::$app->admin->createFreeEnroll($model, $user_id)) {

               return $this->success("Siz ushbu kursga a'zo bo'ldingiz");

            } else {
                return $this->error();
            }
        } else {
            if ($enroll->isExpired) {

                $enroll->generateEndTime($model->duration);
                if (!$enroll->save()) {
                    return $this->error();
                } else {
                    return $this->success("Siz ushbu kursga a'zo bo'ldingiz");
                }

            }
        }
        return $this->success("Siz bu kursga avval a'zo bo'lgansiz!");

    }

}

