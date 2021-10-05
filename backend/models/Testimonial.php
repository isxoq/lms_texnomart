<?php

namespace backend\models;

use Yii;
use common\models\User;
use yii\caching\TagDependency;

/**
 * This is the model class for table "testimonial".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 * @property string $title
 * @property string $text
 *
 * @property User $user
 * @property-read mixed $langs
 * @property $translations array
 */
class Testimonial extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'testimonial';
    }

    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            ['title', 'string', 'max' => 255],
            ['text', 'string'],
            [['title', 'text', 'user_id'], 'required'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['title', 'text'],
            'createdByAttribute' => false,
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'invalidateCacheTags' => 'testimonials',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function find()
    {
        $query = new \soft\db\SActiveQuery(get_called_class());
        return $query->multilingual();
    }

    public static function getDataForIndexPage()
    {
        return Yii::$app->db->cache(function ($db) {
            return static::find()
                ->active()
                ->select('id,user_id')
                ->with([
                    'user' => function ($query) {
                        $query->select('firstname,lastname,avatar');
                    },
                    'translations' => function ($query) {
                        $query->indexBy('language');
                    }
                ])
                ->asArray()
                ->all();

        }, null, new TagDependency(['tags' => ['testimonials']]));
    }

}
