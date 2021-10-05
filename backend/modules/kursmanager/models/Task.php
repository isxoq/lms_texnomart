<?php

namespace backend\modules\kursmanager\models;

use soft\behaviors\DeleteFileBehavior;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text
 * @property string|null $file
 * @property int|null $status
 * @property int|null $lesson_id
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Lesson $lesson
 */
class Task extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'task';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] =
            [
                'class' => DeleteFileBehavior::class,
                'attributes' => 'file',
            ];
        return $behaviors;

    }

    public function rules()
    {
        return [
            [['text'], 'string'],
            [['status', 'lesson_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['title', 'file'], 'string', 'max' => 255],
//            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::className(), 'targetAttribute' => ['lesson_id' => 'id']],
        ];
    }

    public function setAttributeLabels()
    {
        return [
            'title' => 'Topshiriq nomi',
            'text' => 'Tavsif',
            'file' => 'File',
        ];
    }

    public function setAttributeNames()
    {
        return [
            'createdByAttribute' => false, // 'user_id',
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'invalidateCacheTags' => ['task'],
        ];
    }

    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['id' => 'lesson_id']);
    }

    public static function find()
    {
        $query = new \soft\db\SActiveQuery(get_called_class());
        return $query;
    }
}
