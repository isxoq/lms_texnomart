<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;

use backend\models\Rating;
use backend\modules\kursmanager\models\KursComment;
use backend\modules\ordermanager\models\Order;
use frontend\components\UserHistoryBehavior;
use frontend\modules\teacher\models\Lesson;
use Yii;
use backend\modules\kursmanager\models\Enroll;
use frontend\models\Kurs;
use frontend\models\search\KursSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class CourseController extends FrontendController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['free-trial', 'free-enroll', 'enroll', 'leave-comment'],
                'rules' => [
                    [
                        'actions' => ['free-trial', 'free-enroll', 'enroll', 'leave-comment'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            UserHistoryBehavior::class,
        ];
    }


    /**
     * List of all active courses
     * @return string
     */
    public function actionAll()
    {

        $searchModel = new KursSearch();
        $dataProvider = $searchModel->search();

        if ($this->isAjax) {
            return $this->asJson([
                'success' => true,
                'content' => $this->renderAjax('_courses_partials/_courses_grid_view', [
                    'dataProvider' => $dataProvider,
                ])
            ]);
        }

        return $this->render('all', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Kurs detail
     * @param string $id Kurs slug
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDetail($id = '')
    {
        $model = $this->findCourseBySlug($id);
        return $this->render('detail', [
            'model' => $model
        ]);
    }

    /**
     * @param string $id Kurs slug
     * @return string|yii\web\Response
     * @throws yii\web\ForbiddenHttpException|Yii\web\NotFoundHttpException
     */
    public function actionEnroll($id = '')
    {
        $model = $this->findCourseBySlug($id);

        if ($model->is_free) {
            return $this->redirect(['course/free-enroll', 'id' => $id]);
        }

        $enroll = $model->userEnroll;

        if ($enroll != null) {
            if (!$enroll->isExpired) {
                forbidden(t('You have already enrolled this course'));
            }
        }

        $order = Order::findOne([
            'status' => Order::STATUS_NOT_PAYED,
            'user_id' => user('id'),
            'kurs_id' => $model->id,
        ]);

        if ($order == null) {
            $order = new Order([
                'status' => Order::STATUS_NOT_PAYED,
                'user_id' => user('id'),
                'kurs_id' => $model->id,
            ]);
        }
        $order->amount = $model->price;

        if ($order->save()) {
            return $this->redirect(['shop/payment', 'id' => $order->id]);
        }

    }

    /**
     * User tomonidan kurslarga bepul a'zo bo'lish
     * Bu action faqatgina bepul kurslar uchun
     * @param string $id Kurs slug
     * @return string
     * @throws yii\web\NotFoundHttpException|yii\web\ForbiddenHttpException
     */
    public function actionFreeEnroll($id = '')
    {
        $model = Kurs::find()->active()->andWhere(['kurs.slug' => $id])->one();

        if ($model == null) {
            not_found();
        }

        if (!$model->is_free) {
            forbidden();
        }

        $user_id = user('id');

        $enroll = Enroll::findOne(['user_id' => $user_id, 'kurs_id' => $model->id]);

        if ($enroll == null) {

            if (Yii::$app->admin->createFreeEnroll($model, $user_id)) {

                $this->setFlash('success', 'Tabriklaymiz! Siz <b>' . $model->title . "</b> kursiga a'zo bo'ldingiz");
                return $this->redirect('/profile/default/my-courses');

            } else {
                $this->setFlash('error', 'Xatolik yuz berdi!');
                return $this->back();
            }
        } else {
            if ($enroll->isExpired) {
              forbidden("Sizning ushbu kursga a'zolik muddatingiz tugagan!");
            }
        }
        return $this->redirect('/profile/default/my-courses');
    }

    /**
     * Find course by slug
     * @param string $slug Kurs slug value
     * @return Kurs
     * @throws yii\web\NotFoundHttpException if course not found
     */
    private function findCourseBySlug($slug = '')
    {
        $model = Kurs::find()->active()->andWhere(['kurs.slug' => $slug])->one();
        if ($model == null) {
            not_found();
        } else {
            return $model;
        }
    }

    /**
     * Darsni oldindan ko'rish
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionPreview($id = '')
    {

        $lesson = Lesson::findOne($id);

        if ($lesson == null || !$lesson->is_open) {
            not_found();
        }

        return $this->render('preview', [
            'lesson' => $lesson
        ]);
    }

    /**
     * @param $id string Kurs id raqami
     * @return bool
     */
    public function actionAddToWishlist($id)
    {
        if (is_guest()) {
            return false;
        }
        return user()->addToWishList($id);
    }

    /**
     * @param $id string Kurs id raqami
     * @return bool
     */
    public function actionRemoveFromWishlist($id)
    {
        if (is_guest()) {
            return false;
        }
        return user()->removeFromWishList($id);
    }

    public function actionLeaveComment($id)
    {
        $model = $this->findCourseBySlug($id);
        $rating = Rating::findOrCreateModel($model->id);

        if ($rating->load($this->post())) {
            if (!$rating->save()) {
                $this->setFlash('error', 'Xatolik yuz berdi!');
            }
        }

        $comment = new KursComment([
            'user_id' => Yii::$app->user->getId(),
            'kurs_id' => $model->id,
            'status' => KursComment::STATUS_NEW,
            'scenario' => 'leave_comment',
        ]);


        if ($comment->load($this->post())) {

            if (!empty($comment->text)) {

                if (!$comment->save()) {
                    $this->setFlash('error', 'Xatolik yuz berdi!');
                } else {
                    $comment->sendToTelegram();
                    $this->setFlash('success', 'Fikringizni qoldirganingiz uchun rahmat!');
                }

            }
        }

        return $this->redirect(['course/detail', 'id' => $model->slug]);
    }


}