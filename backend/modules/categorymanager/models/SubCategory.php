<?php

namespace backend\modules\categorymanager\models;

use Yii;
use backend\modules\kursmanager\models\Kurs;
use backend\modules\kursmanager\query\KursQuery;
use soft\behaviors\CyrillicSlugBehavior;
use soft\behaviors\EnsureUniqueBehavior;
use soft\helpers\SHtml;
use yii\caching\TagDependency;

/**
 * This is the model class for table "sub_category".
 *
 * @property int $id
 * @property string $title
 * @property string|null $icon
 * @property string|null $image
 * @property string|null $slug
 * @property int|null $category_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 *
 * @property-read string $titleWithIcon
 * @property Category $category
 * @property-read Kurs[] $activeCourses
 * @property-read Kurs[] $courses
 * @property string $uid [varchar(50)]
 */
class SubCategory extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'sub_category';
    }

    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['category_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['icon', 'image', 'slug', 'title', 'uid'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => CyrillicSlugBehavior::class,
        ];
//        $behaviors[] = [
//            'class' => EnsureUniqueBehavior::class,
//        ];
        return $behaviors;
    }

    public function setAttributeLabels()
    {
        return [
            'category_id' => 'Kategoriya',
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['title'],
            'invalidateCacheTags' => ['subCategory'],

        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function find()
    {
        return parent::find()->multilingual()->localized();
    }

    /**
     * Ushbu kategoriyadagi barcha kurslar
     * @return KursQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Kurs::class, ['category_id' => 'id']);
    }

    /**
     * Ushbu kategoriyadagi faol va o'chirilmagan kurslar
     * (asosan frontend uchun)
     * @return KursQuery
     */
    public function getActiveCourses()
    {
        return $this->getCourses()->active()->nonDeleted();
    }

    public function getTitleWithIcon()
    {
        return $this->icon." ".$this->title;
    }

    public static function getSubcategoriesForIndexPage()
    {
        $categories = Yii::$app->db->cache( function ($db){
            return static::find()
             ->active()
             ->asArray()
             ->with(['courses' => function($query){
                 $query->active()->select('category_id');
             } ])
                ->all();
        }, null, new TagDependency(['tags' =>[ 'subCategory', 'kurs']]));

        foreach ($categories as $key => $category){

            $coursesCount = Yii::$app->db->cache( function ($db) use ($category) {
                return \frontend\models\Kurs::find()->active()->andWhere(['category_id' => $category['id'] ])->count();
            }, null, new TagDependency(['tags' => 'kurs']));


            if (intval($coursesCount) < 1){
                unset($categories[$key]);
            }

        }

        return $categories;

    }


    public static function getCategoriesWithTopCourses($categoriesLimit = 6, $coursesLimit = 8)
    {

        return static::find()
            ->active()
            ->joinWith(['activeCourses' => function ($query) use ($coursesLimit) {

                /** @var \soft\db\SActiveQuery $query */
                return $query->orderBy(['kurs.enrolls_count' => SORT_DESC])->limit($coursesLimit);

            }])
            ->orderBy(['kurs.enrolls_count' => SORT_DESC])
            ->limit($categoriesLimit)
            ->asArray()
            ->all()
            ;

    }

}
