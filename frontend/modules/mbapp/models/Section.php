<?php


namespace frontend\modules\mbapp\models;

use Yii;
use yii\caching\TagDependency;

/**
 *
 * @property-read mixed $lessonsForDetailPage
 */
class Section extends \frontend\modules\teacher\models\Section
{

    public function fields()
    {
        return [

            'id',
            'title',
            'sort',
            'duration' => 'formattedActiveLessonsDuration',
            'lessons',
        ];
    }

    public function getLessons()
    {
        return $this->hasMany(Lesson::class, ['section_id' => 'id'])->active();
    }


}