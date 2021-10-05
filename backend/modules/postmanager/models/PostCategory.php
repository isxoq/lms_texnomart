<?php

namespace backend\modules\postmanager\models;

use soft\behaviors\CyrillicSlugBehavior;
use Yii;
use yii\caching\TagDependency;

/**
 *
 * @property-read bool $hasPosts
 * @property-read mixed $posts
 * @property int $id [int(11)]
 * @property string $slug [varchar(127)]
 * @property string $title [varchar(255)]
 * @property-read Post[] $activePosts
 * @property-read int $activePostsCount
 * @property bool $status [tinyint(1)]
 */
class PostCategory extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return '{{%post_category}}';
    }

    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['slug'], 'string', 'max' => 127],
            ['title', 'string', 'max' => 255],
            ['title', 'required'],
        ];
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => CyrillicSlugBehavior::className(),
            'attribute' => 'title',
        ];
        return $behaviors;
    }

    public function setAttributeLabels()
    {
        return [
        ];
    }

    public function setAttributeNames()
    {
        return [

            'multilingualAttributes' => ['title'],
            'updatedAtAttribute' => false,
            'createdAtAttribute' => false,
            'createdByAttribute' => false,
            'invalidateCacheTags' => ['postCategory'],


        ];
    }

    public function deleteConditions()
    {
        return !$this->hasPosts && $this->deletable;
    }

    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }

    public function getHasPosts()
    {
        return $this->getPosts()->count() > 0;
    }

    public static function find()
    {
        $query = new \backend\modules\postmanager\models\query\PostCategoryQuery(get_called_class());
        return $query->multilingual();
    }

    public function isNewSlugNeeded()
    {
        return $this->slug_changeable;
    }

    public function getActivePosts()
    {
        return $this->getPosts()->active()->published();
    }

    public function getActivePostsCount()
    {
        return Yii::$app->db->cache(function ($db) {
            return $this->getActivePosts()->count();
        });
    }

    public static function getDataForBlogSidebar()
    {
        return Yii::$app->db->cache(function ($db) {
            return static::find()->asArray()->active()->forceLocalized()->all();
        }, null, new TagDependency(['tags' => 'postCategory']));
    }

    public static function getActivePostsCountById($categoryId)
    {
        return Yii::$app->db->cache(function ($db) use ($categoryId) {
            return Post::find()->active()->published()->andWhere(['category_id' => $categoryId])->count();
        }, null, new TagDependency(['tags' => 'post']));
    }
}
