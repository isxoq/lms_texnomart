<?php


namespace soft\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\caching\TagDependency;

class InvalidateCacheBehavior extends Behavior
{

    public $tags;


    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'invalidateCache',
            ActiveRecord::EVENT_AFTER_UPDATE => 'invalidateCache',
            ActiveRecord::EVENT_AFTER_DELETE => 'invalidateCache',
        ];
    }

    public function invalidateCache()
    {
        TagDependency::invalidate(Yii::$app->cache, $this->tags);
    }


}