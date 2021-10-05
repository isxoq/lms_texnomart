<?php


namespace frontend\modules\mbapp\models;
use Yii;

/**
 *
 * @property-read mixed $countActiveCourses
 */
class Category extends \backend\modules\categorymanager\models\Category
{

    public function fields()
    {
        return  [
            'id',
            'title',
            'image',
            'coursesCount' => 'countActiveCourses',
        ];
    }

    public static function all()
    {
       return static::find()->active()->all();
    }

    public function getCourses()
    {
        return $this->hasMany(Kurs::class, ['category_id' => 'id'])
            ->via('subCategories');
    }

    public function getActiveCourses()
    {
        return $this->hasMany(Kurs::class, ['category_id' => 'id'])
            ->via('activeSubCategories')
            ->active()
            ->nonDeleted()
            ;
    }

    public function getCountActiveCourses()
    {
        return Yii::$app->db->cache( function ($db)  {
            return $this->getActiveCourses()->count();
        }, 3600*24 );
    }

}