<?php

namespace backend\modules\kursmanager\models;

use backend\models\Certificate;
use backend\modules\kursmanager\behaviors\EnrollBehavior;
use backend\modules\kursmanager\models\query\EnrollQuery;
use common\models\User;
use soft\db\SActiveQuery;
use soft\db\SActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "enroll".
 *
 * @property Kurs $kurs
 * @property User $user
 * @property int $id [int(11)]
 * @property int $end_at [int(11)]  Kurs a'zo bo'lgandan keyin a'zolikning tugash sanasi
 * @property int $user_id [int(11)]
 * @property int $kurs_id [int(11)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 * @property int $status [int(2)]
 * @property int $sold_price [int(11)]  Sotilgan narxi
 * @property int $created_by [int(11)]  Ushbu a'zolik kim tomonidan yaratildi?
 * @property-read bool $isExpired
 * @property string $type [varchar(50)]
 * @property-read mixed $teacher
 * @property-read string $durationField
 * @property-read mixed $completedLessonsCount
 * @property-read string $userLessonsInfo
 * @property-read SActiveQuery $completedLessons
 * @property bool $free_trial [tinyint(1)]
 * @property-read Lesson $lastLesson
 * @property-read mixed $createdBy
 * @property-read LearnedLesson[] $learnedLessons
 * @property-read LearnedLesson[] $activeLearnedLessons
 * @property-read bool $courseIsCompleted
 * @property-read \backend\modules\kursmanager\models\LearnedLesson $lastLearnedLesson
 * @property int $last_lesson_id [int(11)]
 */
class Enroll extends SActiveRecord
{

    /**
     * Kursda mutlaqo bepul a'zo bo'lgan
     */
    public const TYPE_FREE = 'free';

    /**
     * Kursdan ma'lum vaqt bepul foydalanish
     * @see Kurs::$free_duration
     */
    public const TYPE_TRY = 'try';

    /**
     * Kurs sotib olingan
     */
    public const TYPE_PURCHASED = 'purchased';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enroll';
    }


    /**
     * @return array
     */
    public function rules()
    {
        return [

            [['user_id', 'kurs_id'], 'required'],
            ['end_at', 'safe'],

            [['user_id', 'kurs_id', 'status', 'sold_price', 'free_trial', 'last_lesson_id'], 'integer'],
            ['type', 'string', 'max' => 50],
            ['free_trial', 'default', 'value' => 0],
            ['type', 'in', 'range' => [self::TYPE_FREE, self::TYPE_TRY, self::TYPE_PURCHASED]],
            [['kurs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kurs::className(), 'targetAttribute' => ['kurs_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => EnrollBehavior::class
        ];

        $behaviors[] = [
            'class' => TimestampBehavior::class
        ];
        return $behaviors;
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['selectKurs'] = ['user_id', 'kurs_id'];
        return $scenarios;
    }

    /**
     * @return string[]
     */
    public function setAttributeLabels()
    {
        return [
            'kurs_id' => 'Kurs',
            'sold_price' => 'Sotilgan narxi',
            'user_id' => 'Foydalanuvchi',
            'created_by' => 'Yaratildi',
        ];
    }

    /**
     * @return array
     */
    public function setAttributeNames()
    {
        return [
            'createdByAttribute' => 'created_by',
            'invalidateCacheTags' => ['enroll'],
        ];
    }

    /**
     * @return \backend\modules\kursmanager\models\query\EnrollQuery
     */
    public static function find()
    {
        return new EnrollQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastLesson()
    {
        return $this->hasOne(Lesson::class, ['id' => 'last_lesson_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->via('kurs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getLearnedLessons()
    {
        return $this->hasMany(LearnedLesson::class, ['user_id' => 'user_id'])
            ->joinWith('kurs', false)
            ->andWhere(['kurs.id' => $this->kurs_id])
            ->joinWith('section')
            ->joinWith('lesson')
            ->orderBy(['section.sort' => SORT_ASC])
            ->addOrderBy(['lesson.sort' => SORT_ASC]);
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getActiveLearnedLessons()
    {
        return $this->getLearnedLessons()
            ->andWhere(['section.status' => 1])
            ->andWhere(['lesson.status' => 1]);
    }

    public function getLastLearnedLesson()
    {

        return $this->hasOne(LearnedLesson::class, ['user_id' => 'user_id'])
            ->joinWith('kurs', false)
            ->andWhere(['kurs.id' => $this->kurs_id])
            ->orderBy(['learned_lesson.created_at' => SORT_DESC]);
    }

    /**
     * Yangi enroll create bo'layotganda `duration` qiymatiga qarab, `end_at` qiymatni generatsiya qiladi
     * @param string $duration timestamp to render enrollment ending time, such as: "1 year", "6 month"
     */
    public function generateEndTime($duration)
    {
        $begin = strtotime('tomorrow');
        $end = strtotime($duration, $begin);
        $this->end_at = $end;
    }

    /**
     * Whether enroll duration is expired
     * @return bool
     */
    public function getIsExpired()
    {
        return time() > $this->end_at;
    }

    /**
     * @param $user_id int
     * @param $kurs_id int
     * @return Enroll
     */
    public static function findOrCreateModel($user_id, $kurs_id)
    {
        $model = static::findOne([
            'user_id' => $user_id,
            'kurs_id' => $kurs_id,
        ]);

        if ($model == null) {
            $model = new Enroll([
                'user_id' => $user_id,
                'kurs_id' => $kurs_id,
            ]);
        }
        return $model;
    }


    /**
     * @return SActiveQuery
     */
    public function getCompletedLessons()
    {
        return $this->kurs->getLessons()
            ->active()
            ->joinWith('learnedLessons', false)
            ->andWhere(['learned_lesson.user_id' => $this->user_id])
            ->andWhere(['learned_lesson.is_completed' => 1]);
    }

    /**
     * @return int
     */
    public function getCompletedLessonsCount()
    {
        return intval($this->getCompletedLessons()->count());
    }

    /**
     * Userning a'zo bo'lgan vaqti va a'zolikning tugash vaqti haqida ma'lumot
     * Asosan GridView va DetailView uchun
     * @return string
     */
    public function getDurationField()
    {
        $text = "A'zo bo'ldi: ";
        $text .= '<b>' . Yii::$app->formatter->asDateTimeUz($this->created_at) . '</b>';
        $text .= '<br>';
        $text .= 'Tugash sanasi ';
        $text .= '<b>' . Yii::$app->formatter->asDateTimeUz($this->end_at) . '</b>';
        return $text;
    }

    /**
     * Userning nechta mavzuni tugatganligi haqida ma'lumot
     * Asosan GridView va DetailView uchun
     * @return string
     */
    public function getUserLessonsInfo()
    {

        $kurs = $this->kurs;
        $totalActiveLessons = $kurs->activeLessonsCount;
        $completedLessonsCount = $this->getCompletedLessonsCount();
        if ($completedLessonsCount > $totalActiveLessons) {
            $completedLessonsCount = $totalActiveLessons;
        }


        if ($totalActiveLessons <= 0) {
            $percent = '0%';
        } else {

            $percent = Yii::$app->formatter->asPercent($completedLessonsCount / $totalActiveLessons);
        }

        //        $text = 'Jami mavzu: ';
        //  $text = '<b>' . $totalActiveLessons . '</b>';
        //   $text .= '<br>';
//        $text .= 'Tugatildi: ';
//        $text .= '<b>' . $completedLessonsCount . '</b>';
//        $text .= " ($percent)";

        return "$percent (<b>$completedLessonsCount</b> of <b>$totalActiveLessons</b>)";
    }


    /**
     * Ushbu kursdagi hamma mavzular completed bo'lsa, true qaytaradi,
     * ya'ni talaba ushbu kursni tugatgan bo'ladi!
     * @return bool
     */
    public function getCourseIsCompleted()
    {
        $kurs = $this->kurs;
        $totalActiveLessonsCount = $kurs->activeLessonsCount;
        $completedLessonsCount = $this->getCompletedLessonsCount();
        return $completedLessonsCount >= $totalActiveLessonsCount;
    }

    /**
     * @param $lesson_id
     * @return bool
     */
    public function updateLastLesson($lesson_id)
    {
        $this->last_lesson_id = $lesson_id;
        return $this->save(false);
    }


    public function createCertificate()
    {

        $model = Certificate::findOne([
            'user_id' => $this->user_id,
            'kurs_id' => $this->kurs_id,
        ]);

        if ($model) {
            return true;
        }

        $lastLearnedLesson = $this->lastLearnedLesson;

        $model = new Certificate([
            'user_id' => $this->user_id,
            'kurs_id' => $this->kurs_id,
            'date' => $lastLearnedLesson ? $lastLearnedLesson->updated_at : time()
        ]);

        return $model->save();

    }



}
