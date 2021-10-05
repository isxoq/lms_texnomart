<?php


namespace backend\modules\import\models;

use Yii;
use yii\db\ActiveRecord;

class OldLesson extends ActiveRecord
{

    public static function tableName()
    {
        return 'lesson';
    }

    public static function getDb()
    {
        return Yii::$app->db2;
    }


    
}