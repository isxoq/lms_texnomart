<?php

namespace backend\modules\frontendmanager\models;

use soft\db\SActiveRecord;
use Yii;
use yii\caching\TagDependency;

/**
 * This is the model class for table "course_feature".
 *
 * @property int $id
 * @property string|null $icon
 * @property int|null $status
 *
 */
class CourseFeature extends SActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['text', 'string'],
            [['title', 'text', 'icon'], 'required'],
            [['status'], 'integer'],
            [['icon', 'url', 'title', 'url'], 'string', 'max' => 255],
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['title', 'text'],
            'invalidateCacheTags' => 'courseFeature',
        ];
    }

    public static function find()
    {
        return parent::find()->multilingual();
    }

    public static function getDataAsArray()
    {
        return Yii::$app->db->cache(function(){

            return static::find()->active()->forceLocalized()->asArray()->all();

        }, null, new TagDependency(['tags' => 'courseFeature']));
    }

}
