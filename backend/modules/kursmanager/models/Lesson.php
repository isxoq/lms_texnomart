<?php

namespace backend\modules\kursmanager\models;

use backend\modules\kursmanager\models\traits\MediaTrait;
use backend\modules\usermanager\models\User;
use backend\modules\kursmanager\models\LearnedLesson;
use mohorev\file\UploadImageBehavior;
use soft\behaviors\DeleteFileBehavior;
use soft\db\SActiveQuery;
use soft\db\SActiveRecord;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 *
 * @property-read LearnedLesson $learnedLessons
 * @property-read Kurs $kurs
 * @property-read File[] $files
 * @property-read Section $section
 * @property-read bool $hasMedia
 * @property-read \common\models\User $user
 * @property int $id [int(11)]
 * @property string $title [varchar(255)]  Mavzu nomi'
 * @property int $section_id [int(11)]  Bo'lim
 * @property bool $status [tinyint(4)]
 * @property string $description
 * @property bool $deleted [tinyint(1)]
 * @property int $sort [smallint(4)]
 * @property string $media_org_src [varchar(255)]
 * @property string $media_stream_src [varchar(255)]
 * @property string $media_poster [varchar(50)]
 * @property int $media_size [int(11)]  Video hajmi (bayt)
 * @property int $media_duration [smallint(6)]  Video davomiyligi (sekund)
 * @property string $media_extension [varchar(20)]
 * @property int $created_at [int(11)]
 * @property-read mixed $formattedDuration
 * @property-read bool $isCompleted
 * @property-read null|float|int $watchedPercent
 * @property-read null|LearnedLesson $userLearnedLesson
 * @property-read int $watchedDuration
 * @property-read bool $hasBeenCompleted
 * @property-read bool $isOpen
 * @property-read Task[] $tasks
 * @property-read mixed $filesCount
 * @property-read mixed $posterImage
 * @property int $updated_at [int(11)]
 * @property bool $is_open [tinyint(1)]
 * @property-read bool $isStreaming
 * @property-read bool $isStreamFinished
 * @property-read bool $mustBeStreamed
 * @property-read bool $hasNotMedia
 * @property-read mixed $streamStatusLabel
 * @property-read mixed $uploadButton
 * @property mixed $streamStatus
 * @property int $stream_status [int(2)]
 * @property int $stream_percentage [int(11)]
 * @property-read mixed $typeLabel
 * @property-read bool $isTaskLesson
 * @property-read bool $isVideoLesson
 * @property-read bool $hasStreamedVideo
 * @property-read int $startTime
 * @property-read bool $isYoutubeLink
 * @property-read bool $isVideoUploadLesson
 * @property-read bool $isTypeChangeable
 * @property string $type [varchar(20)]
 * @method getThumbUploadUrl(string $string)
 */
class Lesson extends SActiveRecord
{

    use MediaTrait;

    public const TYPE_VIDEO = 'video';
    public const TYPE_YOUTUBE_LINK = 'youtube';
    public const TYPE_TASK = 'task';

    public const MEDIA_PERCENT_FOR_COMPLETE = 70;

    /**
     * Video yuklanmagan holatdagi stream_statusi qiymati
     */
    public const NO_MEDIA = 3;

    /**
     * Video yuklangandan keyin hal stream qilmasdan avval stream_statusi qiymati
     */
    public const MUST_BE_STREAMED = 4;

    /**
     * Video stream qilinayotgan paytdagi stream_status qiymati
     */
    public const IS_STREAMING = 5;

    /**
     * Video stream tugagandan keyingi stream_status qiymati
     */
    public const STREAM_FINISHED = 6;

    /**
     * @var string source attribute for upload media
     */
    public $src;

    private $_streamStatus;

    //<editor-fold desc="Parent methods" defaulstate="collapsed">

    public static function tableName()
    {
        return 'lesson';
    }

    public function rules()
    {
        return [
            [['title', 'section_id'], 'required'],
            [['section_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['title', 'media_org_src', 'media_stream_src'], 'string', 'max' => 255],
            [['media_extension'], 'string', 'max' => 20],
            [['description'], 'string'],
            ['is_open', 'boolean'],
            [['media_duration', 'media_size'], 'integer', 'min' => 0],
            ['media_poster', 'image', 'extensions' => 'jpg, jpeg, gif, png'],
            ['stream_status', 'integer'],
            ['media_duration', 'default', 'value' => 0],
            ['stream_status', 'default', 'value' => self::NO_MEDIA],
            ['type', 'string', 'max' => 20],
            ['type', 'in', 'range' => array_keys(self::getTypesList())],
            ['type', 'default', 'value' => self::TYPE_VIDEO],
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => UploadImageBehavior::class,
                'attribute' => 'media_poster',
                'scenarios' => ['teacher-form', 'default'],
                'path' => '@frontend/web/uploads/poster/{id}',
                'url' => '/uploads/poster/{id}',
                'unlinkOnDelete' => true,
                'deleteOriginalFile' => true,
                'thumbs' => [
                    'thumb' => ['width' => 720, 'quality' => 100],
                ],
            ],
        ]);
    }

    public function setAttributeLabels()
    {
        return [
            'title' => 'Mavzu nomi',
            'section_id' => "Bo'lim",
            'description' => 'Tavsif',
            'media_duration' => 'Videoning davomiyligi',
            'media_size' => 'Videoning hajmi',
            'media_poster' => 'Video uchun poster',
            'streamStatusLabel' => 'Video',
            'type' => 'Dars turi',
            'typeLabel' => 'Dars turi',
        ];
    }

    public static function find()
    {
        return parent::find()->orderBy(['lesson.sort' => SORT_ASC]);
    }

    public function setAttributeNames()
    {
        return [
            'createdByAttribute' => false,
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'invalidateCacheTags' => ['lesson'],
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Has one" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])
            ->via('section');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id'])
            ->via('section');
    }

    // </editor-fold>

    //<editor-fold desc="Lesson types" defaultstate="collapsed">

    public static function getTypesList()
    {
        return [

            self::TYPE_VIDEO => 'Video (yuklash)',
            self::TYPE_YOUTUBE_LINK => 'Video (youtube link)',
            self::TYPE_TASK => 'Topshiriq',

        ];
    }

    public function getTypeLabel()
    {
        return ArrayHelper::getValue(self::getTypesList(), $this->type);
    }

    public function getIsVideoUploadLesson()
    {
        return $this->type == self::TYPE_VIDEO;
    }

    public function getIsVideoLesson()
    {
        return $this->type == self::TYPE_VIDEO || $this->type == self::TYPE_YOUTUBE_LINK;
    }

    public function getIsYoutubeLink()
    {
        return $this->type == self::TYPE_YOUTUBE_LINK;
    }

    public function getIsTaskLesson()
    {
        return $this->type == self::TYPE_TASK;
    }

    // </editor-fold>


    //<editor-fold desc="Lesson media methods" defaultstate="collapsed">

    public function getFormattedDuration()
    {
        return Yii::$app->formatter->asGmtime($this->media_duration);
    }

    // </editor-fold>

    //<editor-fold desc="Files" defaultstate="collapsed">
    /**
     * All files (for downloading) of the lesson
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['lesson_id' => 'id']);
    }

    public function getFilesCount()
    {
        return intval(Yii::$app->db->cache(function ($db) {
            return $this->getFiles()->count();
        }));
    }

    //</editor-fold>

    //<editor-fold desc="Tasks" defaultstate="collapsed">

    /**
     * All tasks of the lesson
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['lesson_id' => 'id']);
    }

    //</editor-fold>

    //<editor-fold desc="Lesson and user (student) relations" defaultstate="collapsed">

    /**
     * @return yii\db\ActiveQuery
     */
    public function getLearnedLessons()
    {
        return $this->hasMany(LearnedLesson::class, ['lesson_id' => 'id']);
    }


    /**
     * Current user tomonidan ushbu mavzuni o'zlashtirish bo'yicha ma'lumotlar
     * Agar uning qiymati nullga teng bo'lsa, mavzu user uchun yopiq bo'ladi
     * User biror mavzuni o'zlashtirsa, keyingi mavzu ochiladi
     * @return yii\db\ActiveQuery|null
     */
    public function getUserLearnedLesson()
    {
        return $this->hasOne(LearnedLesson::class, ['lesson_id' => 'id'])->andWhere(['user_id' => user('id')]);
    }


    /**
     * user_id bo'yicha LearnedLesson ni topish
     * @param $user_id
     * @return \backend\modules\kursmanager\models\LearnedLesson|null
     */
    public function getLearnedLessonByUserId($user_id)
    {
        return LearnedLesson::findOne(['lesson_id' => $this->id, 'user_id' => $user_id]);
    }

    /**
     * Current user tomonidan ushbu mavzuni o'zlashtirish bo'yicha ma'lumotlar
     * Agar uning qiymati nullga teng bo'lsa, mavzu user uchun yopiq bo'ladi
     * User biror mavzuni o'zlashtirsa, keyingi mavzu ochiladi
     * @return bool
     */
    public function getIsOpen()
    {
        return $this->userLearnedLesson != null;
    }

    /**
     * User tomonidan shu mavzudagi videoning necha sekundi ko'rilganligi
     * @return int
     */
    public function getWatchedDuration()
    {
        return $this->isOpen ? intval($this->userLearnedLesson->watched_seconds) : 0;
    }

    /**
     * Current user shu lessondagi videoni necha fozini ko'rilganligi
     * @return float|int|null
     */
    public function getWatchedPercent()
    {

        $duration = intval($this->media_duration);
        if ($duration <= 0) {
            return 100;
        }
        $percent = intval($this->watchedDuration / $duration * 100);
        if ($percent > 100) {
            $percent = 100;
        }
        return $percent;
    }

    /**
     * User tomonidan ayni paytda ushbu lesson completed bo'ldimi yoki yo'qmi shuni tekshiradi !!!
     * todo takomillashtirish kerak
     * @return bool
     */
    public function getHasBeenCompleted()
    {
        if ($this->isTaskLesson || !$this->hasStreamedVideo) {
            return true;
        }
        return $this->watchedPercent >= self::MEDIA_PERCENT_FOR_COMPLETE;
    }

    /**
     * User tomonidan ushbu lesson avvalroq completed bo'lganmi yoki yo'qmi shuni tekshiradi !!!
     * @return bool
     */
    public function getIsCompleted()
    {
        if ($this->userLearnedLesson == null) {
            return false;
        }
        if ($this->userLearnedLesson->is_completed) {
            return true;
        }
        return false;
    }

    /**
     * User uchun lessonga kirganda videoni qaysi sekunddan boshlanishi
     * @return int
     */
    public function getStartTime()
    {
        $userLearnedLesson = $this->userLearnedLesson;
        return $userLearnedLesson == null ? 0 : intval($userLearnedLesson->current_time);
    }

    /**
     * User uchun ushbu lessonni ochish
     * @return bool
     */
    public function open()
    {

        $learnedLesson = $this->userLearnedLesson;
        if ($learnedLesson == null) {
            $learnedLesson = new LearnedLesson([
                'lesson_id' => $this->id,
                'user_id' => user('id'),
            ]);
        }
        if ($this->hasBeenCompleted) {
            $learnedLesson->is_completed = 1;
        }

        return $learnedLesson->save();

    }

    /**
     * User uchun ushbu lessonni completed qilib belgilash
     * @return bool
     */
    public function complete()
    {
        $learnedLesson = $this->userLearnedLesson;
        if ($learnedLesson == null) {
            $learnedLesson = new LearnedLesson([
                'lesson_id' => $this->id,
            ]);
        }

        $learnedLesson->is_completed = 1;
        return $learnedLesson->save();
    }

    // </editor-fold>

    public function getPosterImage()
    {
        return $this->getThumbUploadUrl('media_poster');
    }

    //<editor-fold desc="Delete methods" defaultstate="collapsed">
    public function beforeDelete()
    {

        if (!parent::beforeDelete()) {
            return false;
        }

        $this->deleteOrgSrc();
        $this->deleteStream();
        $this->deleteFiles();
        $this->deleteTasks();

        return true;

    }


    public function deleteFiles()
    {
        foreach ($this->files as $file) {
            /**
             * Fayl model bazadan o'chgandan keyin shu modelga tegishli fayl diskdan o'chirib yuboriladi
             * @see File::behaviors()
             * @see DeleteFileBehavior
             **/
            $file->delete();
        }
    }

    public function deleteTasks()
    {
        foreach ($this->tasks as $task) {
            /**
             * Fayl model bazadan o'chgandan keyin shu modelga tegishli fayl diskdan o'chirib yuboriladi
             * @see File::behaviors()
             * @see DeleteFileBehavior
             **/
            $task->delete();
        }
    }

    // </editor-fold>

    //<editor-fold desc="Stream statuses" defaultstate="collapsed">

    private function defineStreamStatus()
    {
        $status = $this->stream_status;

        if ($status == self::STREAM_FINISHED) {
            $result = self::STREAM_FINISHED;
        } else if ($status == self::IS_STREAMING) {
            $result = self::IS_STREAMING;
        } else if ($status == self::MUST_BE_STREAMED) {
            $result = self::MUST_BE_STREAMED;
        } else if (!empty($this->media_stream_src)) {
            $result = self::STREAM_FINISHED;
        } else {
            $result = self::NO_MEDIA;
        }

        $this->setStreamStatus($result);
    }

    private function setStreamStatus($status)
    {
        $this->_streamStatus = $status;
    }

    public function getStreamStatus()
    {
        if (empty($this->_streamStatus)) {
            $this->defineStreamStatus();
        }
        return $this->_streamStatus;
    }

    /**
     * @return bool Mavzu stream qilingan videosi yo'q bo'lsa true qaytaradi
     */
    public function getHasNotMedia()
    {
        return $this->getStreamStatus() == self::NO_MEDIA;
    }

    /**
     * @return bool Mavzuga video yuklangandan keyin, hali stream qilinmagan holati
     */
    public function getMustBeStreamed()
    {
        return $this->getStreamStatus() == self::MUST_BE_STREAMED;
    }

    /**
     * @return bool Mavzudagi Videon stream qilinayotgan paytdagi holati
     */
    public function getIsStreaming()
    {
        return $this->getStreamStatus() == self::IS_STREAMING;
    }

    /**
     * @return bool Mavzu stream qilingan videosi bor bo'lsa true qaytaradi
     */
    public function getIsStreamFinished()
    {
        return $this->getStreamStatus() == self::STREAM_FINISHED;
    }

    public function getStreamStatusLabel()
    {

        if ($this->getHasNotMedia()) {
            return $this->getUploadButton();
        } else {

            if ($this->getMustBeStreamed() || $this->getIsStreaming()) {
                return tag('small', "Yuklangan videoni birozdan so'ng ko'rishingiz mumkin", ['class' => 'text-muted']);
            } else {
                return $this->getFormattedDuration();
            }
        }
    }

    public function getUploadButton()
    {
        return a('Video yuklash', ['lesson/upload', 'id' => $this->id], ['class' => 'text-primary', 'data-pjax' => 0], 'upload');
    }

    //</editor-fold>

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isAttributeChanged('media_stream_src')) {
            if ($this->isYoutubeLink) {
                $this->media_duration = $this->media_stream_src ? $this->getYoutubeVideoDuration() : 0;
            }
        }
        return true;
    }

    public function getIsTypeChangeable()
    {
        return $this->isNewRecord || !$this->isVideoUploadLesson;
    }

}
