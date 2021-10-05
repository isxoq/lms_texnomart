<?php

namespace backend\modules\kursmanager\models;

use Yii;
use backend\modules\usermanager\models\User;
use yii\caching\TagDependency;

/**
 * This is the model class for table "section".
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property int|null $kurs_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 *
 * @property Kurs $kurs
 * @property User $user
 * @property int $sort [smallint(6)]
 * @property-read mixed $lessons
 * @property-read mixed $activeLessons
 * @property-read mixed $lessonsCount
 * @property-read mixed $activeLessonsCount
 * @property-read null|bool|string|int $videosCount
 * @property-read mixed $formattedVideosDuration
 * @property-read \yii\db\ActiveQuery $lessonsHasVideos
 * @property-read null|bool|string|mixed|int $videosDuration
 * @property-read mixed $activeLessonsDuration
 * @property-read mixed $formattedActiveLessonsDuration
 * @property bool $deleted [tinyint(4)]
 *
 */
class Section extends \soft\db\SActiveRecord
{
    public static function tableName()
    {
        return 'section';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['kurs_id',  'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            ['deleted', 'default', 'value' => 0],
            [['kurs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kurs::className(), 'targetAttribute' => ['kurs_id' => 'id']],
        ];
    }

    public function setAttributeLabels()
    {
        return [
            'title' => "Bo'lim nomi",
            'kurs_id' => 'Kurs',
            'kurs.title' => 'Kurs',
            'countLessons' => "Mavzular soni",

        ];
    }

    public function setAttributeNames()
    {
        return [

            'createdByAttribute' => false,
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'invalidateCacheTags' => ['section'],


        ];
    }

    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->via('kurs');
    }

    public static function find()
    {
        return parent::find()->orderBy(['section.sort' => SORT_ASC]);
    }


    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        $lessons = $this->lessons;

        foreach ($lessons as $lesson){

            /**
             * @see Lesson::beforeDelete()
             **/
            $lesson->delete();
        }

        return true;
    }

    //<editor-fold desc="Lessons" defaultstate="collapsed">

    /**
     * Ushbu section ichidagi mavzular
     * @return \yii\db\ActiveQuery
     * @throws \Throwable
     */
    public function getLessons()
    {
        return Yii::$app->db->cache( function ($db){
            return  $this->hasMany(Lesson::class, ['section_id' => 'id']);
        }, null, new TagDependency(['tags' => 'lesson']));
    }

    public function getLessonsCount()
    {
        return Yii::$app->db->cache( function ($db){
            return  $this->getLessons()->count();
        }, null, new TagDependency(['tags' => 'lesson']));
    }

    public function getActiveLessons()
    {
        return Yii::$app->db->cache( function ($db){
            return $this->getLessons()->active();
        }, null, new TagDependency(['tags' => 'lesson']));
    }

    public function getActiveLessonsCount()
    {
        return Yii::$app->db->cache( function ($db){
            return  $this->getActiveLessons()->count();
        }, null, new TagDependency(['tags' => 'lesson']));
    }

    public function getActiveLessonsDuration()
    {
        return intval($this->getActiveLessons()->sum('media_duration'));
    }

    public function getFormattedActiveLessonsDuration()
    {
        return Yii::$app->formatter->asGmtime($this->getActiveLessonsDuration());
    }

    //</editor-fold>

    //<editor-fold desc="Videos" defaultstate="collapsed">

    /**
     * Videosi bor mavzular - barchasi
     * @return \yii\db\ActiveQuery
     * @throws \Throwable
     */
    public function getLessonsHasVideos()
    {
        return $this->getLessons()->andWhere([ '>', 'lesson.media_duration', 0 ]);
    }

    /**
     * Kursdagi videolar soni ( Videosi bor mavzular soni) - barchasi
     * @return bool|int|string|null
     * @throws \Throwable
     */
    public function getVideosCount()
    {
        return $this->getLessonsHasVideos()->count();
    }


    /**
     * kurs ichidagi videolarning davomiyligu
     * @return bool|int|mixed|string|null
     * @throws \Throwable
     */
    public function getVideosDuration()
    {
        return $this->getLessonsHasVideos()->sum('media_duration');
    }

    public function getFormattedVideosDuration()
    {
        return Yii::$app->formatter->asGmtime($this->videosDuration);
    }
    //</editor-fold>


}
