<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "education_level".
 *
 * @property int $id
 * @property int|null $status
 * @property string|null $name
 *
 */
class EducationLevel extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'education_level';
    }

    public function rules()
    {
        return [
            [['status'], 'integer'],
            ['name' , 'string', 'max' => 255],
            ['name' , 'required'],

        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => ['name'],
            'createdByAttribute' => false, // 'user_id',
            'createdAtAttribute' => false, // 'created_at',
            'updatedAtAttribute' => false, //'updated_at',
            'invalidateCacheTags' => 'educationLevel',
        ];
    }


    public static function find()
    {
        $query = new \soft\db\SActiveQuery(get_called_class());
        return $query->multilingual();
    }
}
