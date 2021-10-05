<?php


namespace backend\modules\import\models;

use Yii;
use yii\db\ActiveRecord;

class OldCategory extends ActiveRecord
{

    public static function tableName()
    {
        return 'category';
    }

    public static function getDb()
    {
        return Yii::$app->db2;
    }

    public function getSubItems()
    {
        return $this->hasMany(self::class, ['parent' => 'id']);
    }

}