<?php

namespace backend\modules\kursmanager\models;
use Yii;
use common\models\User;

/**
 * This is the model class for table "learned_lesson".
 *
 * @property int $id
 * @property int|null $lesson_id
 * @property int|null $user_id
 * @property int|null $is_completed
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Lesson $lesson
 * @property User $user
 * @property int $watched_seconds [smallint(6)]  Total watched seconds by user
 * @property-read mixed $section
 * @property-read mixed $kurs
 * @property-read mixed $watchedPercent
 * @property int $current_time [smallint(6)]  Last watched point
 * @property mixed|null statusIcon
 */
class LearnedLesson extends \soft\db\SActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'learned_lesson';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lesson_id', 'user_id', 'is_completed'], 'integer'],
            ['is_completed', 'default', 'value' => 0],
            [['watched_seconds', 'current_time'], 'integer', 'min' => 0],
            [['watched_seconds', 'current_time'], 'default', 'value' => 0],

            ['user_id', 'unique', 'targetAttribute' => ['user_id', 'lesson_id']],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
//            [['lesson_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lesson::className(), 'targetAttribute' => ['lesson_id' => 'id']],


        ];
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getLesson()
    {
        return $this->hasOne(Lesson::className(), ['id' => 'lesson_id']);
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id'])->via('lesson');
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getKurs()
    {
        return $this->hasOne(Kurs::class, ['id' => 'kurs_id'])->via('section');
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public function setAttributeNames()
    {
        return [
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'invalidateCacheTags' => ['learnedLesson'],
        ];
    }

    public function getWatchedPercent()
    {
        if (!$this->lesson->media_duration){
            return  '';
        }
        return Yii::$app->formatter->asPercent($this->watched_seconds/$this->lesson->media_duration);
    }

    public function getStatusIcon()
    {
        $iconClass = $this->is_completed ? 'far fa-check-square' : 'far fa-square';
        return "<i class='$iconClass'></i>";
    }

}
