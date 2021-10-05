<?php

namespace backend\modules\frontendmanager\models;

use backend\modules\kursmanager\query\KursQuery;
use Yii;
use backend\modules\kursmanager\models\Kurs;
use yii\caching\TagDependency;

/**
 * This is the model class for table "course_slider".
 *
 * @property int $id
 * @property int $course_id
 * @property string|null $title
 * @property string|null $text
 * @property string|null $image
 * @property string|null $little_image
 * @property int|null $status
 *
 * @property Kurs $course
 * @property int $sort_order [int(3)]
 * @property string $icon [varchar(255)]
 */
class CourseSlider extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'course_slider';
    }

    public function rules()
    {
        return [

            [['title', 'text'], 'required'],
            [['title', 'text', 'icon'], 'string', 'max' => 255],
            [['course_id'], 'required'],
            [['course_id', 'status'], 'integer'],
            [['image', 'little_image'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kurs::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    public function setAttributeLabels()
    {
        return [
            'course_id' => "Kurs",
            'course.title' => "Kurs nomi",
            'image' => "Asosiy rasm (1475x800)",
            'little_image' => "Kichik rasm (400x200)",
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['title', 'text'],
            'createdByAttribute' => false, // 'user_id',
            'createdAtAttribute' => false, // 'created_at',
            'updatedAtAttribute' => false, //'updated_at',
            'invalidateCacheTags' => 'courseSlider',
        ];
    }


    /**
     * @return KursQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'course_id']);
    }

    public static function find()
    {
        $query = new \soft\db\SActiveQuery(get_called_class());
        return $query->multilingual()->orderBy(['sort_order' => SORT_ASC ]);
    }

    public static function getDataForIndexPage()
    {

        return  Yii::$app->db->cache( function ($db){
            return static::find()->active()
                ->forceLocalized()
                ->with(['course' => function($query){
                    return $query->select(['id', 'title', 'slug', 'price', 'old_price', 'is_free']);
                }])
                ->asArray()->all();
        }, null, new TagDependency(['tags' => 'courseSlider']));

    }
}
