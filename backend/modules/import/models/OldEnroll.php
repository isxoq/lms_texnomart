<?php


namespace backend\modules\import\models;

use backend\modules\kursmanager\models\Lesson;
use Yii;
use yii\db\ActiveRecord;


class OldEnroll extends ActiveRecord
{

    public static function tableName()
    {
        return 'enrol';
    }

    public static function getDb()
    {
        return Yii::$app->db2;
    }



}