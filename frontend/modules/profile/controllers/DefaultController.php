<?php

namespace frontend\modules\profile\controllers;


use soft\web\SController;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use backend\modules\kursmanager\models\Enroll;

/**
 * Class DefaultController
 * Profile moduli uchun default controller
 * @package frontend\modules\profile\controllers
 */
class DefaultController extends SController
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

            \frontend\components\UserHistoryBehavior::class,

        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionMyCourses()
    {

        $query = user()->getEnrolledCourses()->with(['user', 'subCategory.category']);
        $allCount = $query->count();
        if ($allCount < 1){
            return $this->render('noCourseView');
        }

        $title = $this->request->get('title');

        if ($title != null && is_string($title)){
            $query->andWhere(['like',  'kurs.title', $title]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 9
            ]
        ]);
        return $this->render("myCourses", [
            'dataProvider' => $dataProvider,
            'allCount' => $allCount,

        ]);
    }

    public function actionEnrollingInfo($id = '')
    {

        if ($this->isAjax){
            $this->formatJson;
        }

        $enroll = Enroll::find()
            ->andWhere(['kurs_id' => $id, 'user_id' => user('id')])
            ->orderBy(['id' => SORT_DESC])
            ->one();
        if ($enroll == null){
            not_found();
        }
        if ($this->isAjax){

            return [

                'title' => "A'zolik haqida ma'lumot",
                'content' =>    $this->renderAjax('enrollInfo', [
                    'enroll' => $enroll
                ]),
                'footer' => Html::button("Yopish", ['class' => 'btn btn-warning pull-left', 'data-dismiss' => "modal"]),
            ];

        }
        else{
            return $this->render('enrollInfo', [
                'enroll' => $enroll
            ]);
        }
    }


}
