<?php

namespace backend\modules\categorymanager\models;

use backend\modules\kursmanager\models\Kurs;
use backend\modules\kursmanager\query\KursQuery;
use soft\behaviors\CyrillicSlugBehavior;
use soft\behaviors\EnsureUniqueBehavior;
use soft\helpers\SHtml;
use Yii;
use yii\caching\TagDependency;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string|null $icon
 * @property string|null $image
 * @property string|null $slug
 * @property int|null $status
 * @property int|null $created_at
 * @property-read mixed $subCategories
 * @property-read string $titleWithIcon
 * @property int|null $updated_at
 * @property-read mixed $activeSubCategories
 * @property-read Kurs[] $activeCourses
 * @property-read Kurs[] $courses
 * @property-read Kurs[] $topActiveCourses
 * @property string $uid [varchar(50)]
 */
class Category extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        return [
            ['title', 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'icon', 'image', 'slug', 'uid'], 'string', 'max' => 255],
        ];
    }

    public function setAttributeLabels()
    {
        return [
            'icon' => 'Icon',
        ];
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => CyrillicSlugBehavior::class,
        ];
        $behaviors[] = [
            'class' => EnsureUniqueBehavior::class,
        ];
        return $behaviors;
    }

    public function setAttributeNames()
    {
        return [

            'createdByAttribute' => false,
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',

            'multilingualAttributes' => ['title'],
            'invalidateCacheTags' => ['category'],

        ];
    }

    public static function find()
    {
        $query = parent::find();
        return $query->multilingual();
    }

    public function getSubCategories()
    {
        return $this->hasMany(SubCategory::class, ['category_id' => 'id']);
    }

    public function getActiveSubCategories()
    {
        return $this->getSubCategories()->active();
    }

    /**
     * Ushbu kategoriyadagi barcha kurslar
     * @return KursQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Kurs::class, ['category_id' => 'id'])
            ->via('subCategories');
    }

    /**
     * Ushbu kategoriyadagi faol sub categoriyalar ichidagi faol va o'chirilmagan kurslar
     * (asosan frontend uchun)
     * @return KursQuery
     */
    public function getActiveCourses()
    {
        return $this->hasMany(Kurs::class, ['category_id' => 'id'])
            ->via('activeSubCategories')
            ->active()
            ->nonDeleted();
    }

    public function getTitleWithIcon()
    {
        return $this->icon . " " . $this->title;
    }


    public static function getCategoriesForIndexPage()
    {
        return Yii::$app->db->cache(function ($db) {
            return static::find()
                ->active()
                ->asArray()
                ->forceLocalized()
                ->all();
        }, null, new TagDependency(['tags' => ['category']]));

    }

    public static function getCoursesCount($categoryId = '')
    {
        return Yii::$app->db->cache(function ($db) use ($categoryId) {
            return \frontend\models\Kurs::find()
                ->active()
                ->joinWith('subCategory', false)
                ->andWhere(['sub_category.category_id' => $categoryId])
                ->count();
        }, null, new TagDependency(['tags' => ['kurs']]));
    }

    /**
     * Get top categories for 'top courses' section on index page
     * @param int $categoriesLimit
     * @return static[]
     */
    public static function topCategories($categoriesLimit = 6)
    {
        return static::find()
            ->active()
            ->limit($categoriesLimit)
            ->all();
    }


    public static function categoriesForMenu()
    {

        return static::find()
            ->active()
            ->with(['subCategories' => function($query){
                /** @var \soft\db\SActiveQuery $query */
                return $query->select('id,slug,status,category_id')->asArray()->forceLocalized()->limit(8);
            }])
            ->forceLocalized()
            ->select('id,slug,status,image')
            ->asArray()
            ->all()
            ;

    }


}
