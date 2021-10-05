<?php


namespace frontend\models;

use Yii;
use yii\caching\TagDependency;

/**
 *
 * @property-read mixed $activeLessonsAsArray
 */
class Section extends \frontend\modules\teacher\models\Section
{
    public function rules()
    {
        return [];
    }

    public function behaviors()
    {
        return [];
    }

    /**
     * Kurs detail sahifasi uchun section ichidagi mavzular ro'yxati
     * @return array
     * @throws \Throwable
     */
    public function getActiveLessonsAsArray()
    {
        return Yii::$app->db->cache( function ($db){
            return  $this->getActiveLessons()
             ->select(['status','is_open', 'title', 'id', 'section_id', 'media_duration', 'sort'])
             ->orderBy(['lesson.sort' => SORT_ASC])
             ->asArray();
        }, null, new TagDependency(['tags' => ['lesson']]));
    }

}