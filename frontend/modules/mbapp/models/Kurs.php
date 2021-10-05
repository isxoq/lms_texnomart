<?php

namespace frontend\modules\mbapp\models;

use Yii;

/**
 *
 * @property array $fields
 * @property-read mixed $activeSectionsWithActiveLessons
 * @property-read array $includes
 * @property-read bool $youtube
 * @property-read string $formattedVideLink
 * @property-read mixed $userFullName
 */
class Kurs extends \frontend\models\Kurs
{

    public $_fields;

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * @param mixed $fields
     */
    public function setFields($fields)
    {
        $this->_fields = $fields;
    }

    public function fields()
    {
        if ($this->fields == null) {
            return [
                'id',
                'title',
                'price',
                'formattedPrice',
                'author' => 'userFullName',
                'image' => 'kursImage',
                'rating' => 'averageRating',
                'ratingsCount',
                'is_free',
            ];
        } else {
            return $this->fields;
        }
    }

    public static function findActiveOne($id = '')
    {
        return static::find()->andWhere(['id' => $id])->nonDeleted()->active()->one();
    }

    public static function bestCourses($limit = 6)
    {
        return static::find()
            ->orderBy('enrolls_count DESC')
            ->limit($limit)
            ->cache(3600)
            ->active()
            ->andWhere(['!=', 'is_free', 1])
            ->select(['id', 'title', 'price', 'image', 'slug', 'is_free', 'user_id', 'is_free'])
            ->all();
    }

    public static function allCourses($search = null)
    {
        return static::find()->orderBy('enrolls_count DESC')
            ->select(['id', 'title', 'price', 'image', 'slug', 'is_free', 'user_id', 'is_free'])
            ->active()
            ->andFilterWhere(['like', 'title', $search])
            ->latest()
            ->cache(3600)
            ->all();
    }

    public function getUserFullName()
    {
        return $this->user->fullname;
    }

    public function getSections()
    {
        return $this->hasMany(Section::class, ['kurs_id' => 'id'])->active();

    }

    public function getActiveSectionsWithActiveLessons()
    {
        return $this->getActiveSections()
            ->select('id,title,kurs_id,status,sort')
            ->with('activeLessons')->all();
    }

    public function getIncludes()
    {
        return [

            t('Lessons count') . ": " . $this->activeLessonsCount,
            t('Duration') . ": " . $this->formattedActiveLessonsDuration,
            t('Language') . ": " . $this->languageText,
            t('Level') . ": " . $this->levelText,
            t('Teacher') . ": " . $this->user->fullname,
            t('Enroll duration') . ": " . $this->durationText,

        ];
    }

    public function getYoutube()
    {
        $previewLink = $this->preview_link;
        if (empty($previewLink)) {
            return false;
        }

        if (strpos($previewLink, 'youtu') === false) {
            return false;
        } else {
            return true;
        }

    }


    public function getFormattedVideLink()
    {
        if (empty($this->preview_link)) {
            return '';
        }
        return $this->preview_link;
    }

}