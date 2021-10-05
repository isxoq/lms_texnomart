<?php

namespace frontend\modules\teacher\models;

use Yii;

class File extends \backend\modules\kursmanager\models\File
{
    /**
     * @param string $id
     * @return File
     * @throws yii\web\NotFoundHttpException|yii\web\ForbiddenHttpException
     */
    public static function findOwnModel($id = '')
    {
        $model = self::find()->id($id)->one();
        if ($model == null){
            not_found();
        }
        if ($model->kurs->user_id != Yii::$app->user->identity->id){
            forbidden();
        }
        return $model;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['teacher-form'] = ['title',  'file', 'status', 'description'];
        return $scenarios;
    }




}