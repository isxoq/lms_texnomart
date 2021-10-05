<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 07.06.2021, 10:32
 */

namespace frontend\controllers;


use common\models\User;
use yii\data\ActiveDataProvider;

class InstructorController extends FrontendController
{

    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => User::find()
                ->andWhere(['user.status' => User::STATUS_ACTIVE, 'type' => User::TYPE_TEACHER])
                ->joinWith('courses', false)
                ->andWhere(['kurs.status' => 1])
                ->distinct()
            ,

            'pagination' => [
                'defaultPageSize' => 12
            ]

        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionSingle($id)
    {
        $model = User::findOne(['id' => $id, 'status' => User::STATUS_ACTIVE, 'type' => User::TYPE_TEACHER]);

        if ($model == null) {
            not_found();
        }
        return $this->render('single', [
            'model' => $model,
        ]);

    }

}