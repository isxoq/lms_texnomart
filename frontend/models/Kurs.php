<?php

namespace frontend\models;

use mohorev\file\UploadImageBehavior;
use Yii;
use yii\caching\TagDependency;

/**
 *
 * @property-read string $detailUrl
 * @property-read array $activeSectionsForDetailPage
 * @property-read mixed $countSections
 */
class Kurs extends \frontend\modules\teacher\models\Kurs
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [];
    }

    public function behaviors()
    {
        return [
            'uploadImage' => [
                'class' => UploadImageBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['teacher-form', 'default'],
                'path' => '@frontend/web/uploads/course/{id}',
                'url' => '/uploads/course/{id}',
                'unlinkOnDelete' => true,
                'deleteOriginalFile' => true,
                'thumbs' => [
                    'thumb' => ['width' => 370, 'quality' => 100],
                ],
            ]
        ];
    }

    public function getSections()
    {
        return Yii::$app->db->cache(function ($db) {
            return $this->hasMany(Section::class, ['kurs_id' => 'id']);
        }, null, new TagDependency(['tags' => 'section']));
    }

    public function getCountSections()
    {
        return count($this->sections);
    }

    public function getActiveSections()
    {
        return Yii::$app->db->cache(function ($db) {
            return $this->getSections()->active();
        }, null, new TagDependency(['tags' => ['section']]));
    }

    public function getDetailUrl()
    {
        return to(['course/detail', 'id' => $this->slug]);
    }

    public function getFreeEnrollButton($options = [])
    {
        return a(t('Enroll'), ['/course/free-enroll', 'id' => $this->slug], $options);
    }

    public function getFreeEnrolledButton($options = [])
    {
//        Html::addCssStyle($options, ['cursor' => 'not-allowed']);
        return a(t('Start lesson'), ['/profile/start', 'id' => $this->id], $options);
    }

    public function getPurchaseButton($options = [])
    {
        return a(t('Purchase'), ['/course/enroll', 'id' => $this->slug], $options);
    }

    public function getPurchasedButton($options = [])
    {
//        Html::addCssStyle($options, ['cursor' => 'not-allowed']);
        return a(t('Start lesson'), ['/profile/start', 'id' => $this->id], $options);
    }

    public function getCardButton($options = [])
    {
        $options['data-pjax'] = 0;

        if (is_guest()) {
            if ($this->is_free) {
                return $this->getFreeEnrollButton($options);
            } else {
                return $this->getPurchaseButton($options);
            }
        } else {
            if ($this->is_free) {
                if (!$this->userHasEnrolled || $this->userEnroll->isExpired) {
                    return $this->getFreeEnrollButton($options);
                } else {
                    return $this->getFreeEnrolledButton($options);
                }
            } else {
                if (!$this->userHasEnrolled || $this->userEnroll->isExpired) {
                    return $this->getPurchaseButton($options);
                } else {
                    return $this->getPurchasedButton($options);
                }
            }
        }
    }

    /**
     * @param int $limit
     * @return \frontend\models\Kurs[]
     */
    public function relatedCourses($limit = 3)
    {
        $relatedCourses = Kurs::find()
            ->andWhere(['!=', 'kurs.id', $this->id])
            ->andWhere(['kurs.category_id' => $this->category_id])
            ->latest($limit)
            ->indexBy('id')
            ->active()
            ->all();

        $count = count($relatedCourses);

        if ($count >= $limit) {
            return $relatedCourses;
        }

        $leftCount = $limit - $count;

        $relatedCourses2 = Kurs::find()
            ->andWhere(['!=', 'kurs.id', $this->id])
            ->andWhere(['!=', 'kurs.category_id', $this->category_id])
            ->random($leftCount)
            ->indexBy('id')
            ->joinWith('category', false)
            ->andWhere(['category.id' => $this->category->id])
            ->active()
            ->all();
        return array_merge($relatedCourses, $relatedCourses2);

    }

    /**
     * @return \frontend\models\Kurs[]
     */
    public static function popularCourses()
    {
        return Yii::$app->db->cache(function ($db) {
            return Kurs::find()->orderBy('enrolls_count DESC')
                ->limit(4)
                ->select(['id', 'title', 'price', 'image', 'slug', 'is_free'])
                ->all();
        });
    }

    public function getActiveSectionsForDetailPage()
    {
        return Yii::$app->db->cache(function ($db) {
            return $this->getActiveSections()
                ->select('id,title,sort')
                ->all();
        }, null, new TagDependency(['tags' => ['section', 'lesson']]));
    }


    /**
     * site/page sahifasidagi sidebar uchun oxirgi kurslar
     * sorted by published_at property
     * @return static[]
     */
    public static function getLatestCoursesForPageSidebar()
    {
        return Yii::$app->db->cache(function ($db) {
            return Kurs::find()
                ->recently(6)
                ->active()
                ->with([
                    'user' => function ($query) {
                        return $query->select(['id', 'firstname', 'lastname']);
                    },
                ])
//                ->select('id,title,published_at,image,user_id,slug')
//                ->asArray()
                ->all();
        }, null, new TagDependency(['tags' => ['user', 'kurs']]));
    }

    /**
     * Top courses for 'top courses' section on index poge
     * @param $category_id
     * @param int $limit
     * @return static[]
     */
    public static function topCourses($category_id = null, $limit = 8)
    {
        return static::find()
            ->active()
            ->cache()
            ->select([
                '{{kurs}}.*',
                'AVG({{rating}}.rate) AS averageRating'
            ])
            ->joinWith('validRatings', false)
            ->joinWith('category', false)
            ->andFilterWhere(['category.id' => $category_id])
            ->groupBy('{{kurs}}.id')
            ->orderBy(['kurs.enrolls_count' => SORT_DESC])
            ->limit($limit)
            ->with([
                'user' => function ($query) {
                    return $query->select(['id', 'firstname', 'lastname'])->asArray();
                },
            ])
            ->all();

    }

    /**
     * Top courses for 'top courses' section on index poge
     * @param $category_id
     * @param int $limit
     * @return static[]
     */
    public static function latestCourses($limit = 8)
    {
        return static::find()
            ->active()
//            ->select([
//                '{{kurs}}.*',
//                'AVG({{rating}}.rate) AS averageRating'
//            ])
//            ->joinWith('validRatings', false)
//            ->groupBy('{{kurs}}.id')
//            ->orderBy(['kurs.enrolls_count' => SORT_DESC])
            ->recently($limit)
            ->with([
                'user' => function ($query) {
                    return $query->select(['id', 'firstname', 'lastname'])->asArray();
                },
            ])
            ->all();

    }

}