<?php


namespace frontend\modules\mbapp\controllers;


use frontend\components\UserHistoryBehavior;
use frontend\modules\mbapp\models\Category;
use Mobile_Detect;

class CategoryController extends DefaultController
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
        return Category::all();
    }

    public function actionCourses($id='')
    {
        $model = Category::find()->active()->andWhere(['id' => $id])->one();
        if ($model == null){
            return $this->error("Kategoriya topilmadi!");
        }
        return $model->activeCourses;
    }

    public function actionHistory()
    {
        $device = new Mobile_Detect();
        return $device->isDesktopMode();
    }

}