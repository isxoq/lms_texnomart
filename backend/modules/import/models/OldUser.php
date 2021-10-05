<?php
namespace backend\modules\import\models;
use Yii;
class OldUser extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }

    public static function getDb()
    {
         return Yii::$app->db2;
    }


}