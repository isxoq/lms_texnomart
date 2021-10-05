<?php


namespace backend\modules\import\models;

use backend\modules\kursmanager\models\Lesson;
use Yii;
use yii\db\ActiveRecord;


class OldSection extends ActiveRecord
{

    public static function tableName()
    {
        return 'section';
    }

    public static function getDb()
    {
        return Yii::$app->db2;
    }

    public function getLessons()
    {
        return $this->hasMany(OldLesson::class, ['section_id' => 'id']);
    }


}