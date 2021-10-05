<?php


namespace frontend\models;


use Yii;
use yii\caching\TagDependency;

/**
 *
 * @property-read mixed $shortContent
 * @property-read mixed $detailUrl
 */
class Post extends \backend\modules\postmanager\models\Post
{

    public function rules()
    {
        return [];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['title', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'tags'],
            'createdAtAttribute' => false,
            'createdByAttribute' => false,
            'updatedAtAttribute' => false,
        ];
    }

    public function getDetailUrl()
    {
        return to(['blog/detail', 'id' => $this->slug]);
    }

    /**
     * Recent posts as array for blog sidebar
     * @param int $limit
     * @return mixed
     * @throws \Throwable
     */
    public static function recentPosts($limit=5)
    {
        return Yii::$app->db->cache(function ($db) use($limit) {
            return static::find()
                ->active()
                ->recently($limit)
                ->published()
                ->with(['translation' => function ($query) {
                    return $query->select('id,owner_id,language,title');
                }])
                ->without('translations')
                ->asArray()
                ->all();
        }, null, new TagDependency(['tags' => 'post']));
    }

    /**
     * Recent posts as array for index page
     * @param int $limit
     * @return mixed
     * @throws \Throwable
     */
    public static function recentPostsForIndexPage($limit=4)
    {
        return Yii::$app->db->cache(function ($db) use($limit) {
            return static::find()
                ->active()
                ->recently($limit)
                ->published()
                ->with(['translation' => function ($query) {
                    return $query->select('id,owner_id,language,title,content');
                }])
                ->without('translations')
                ->asArray()
                ->all();
        }, null, new TagDependency(['tags' => 'post']));
    }


}