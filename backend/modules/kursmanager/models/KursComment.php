<?php

namespace backend\modules\kursmanager\models;

use backend\models\Rating;
use Yii;
use soft\db\SActiveRecord;
use backend\modules\usermanager\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "kurs_comment".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $kurs_id
 * @property string $text
 * @property int|null $reply_id
 * @property int|null $created_at
 * @property int $updated_at [int(11)]
 * @property int|null $status
 *
 * @property Kurs $kurs
 * @property KursComment $reply
 * @property KursComment[] $replies
 * @property-read int|null $userRating
 * @property-read Rating $rating
 * @property-read int $repliesCount
 * @property User $user
 */
class KursComment extends SActiveRecord
{

    public const STATUS_NEW = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kurs_comment';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'kurs_id', 'reply_id', 'status'], 'integer'],
            [['text'], 'string'],
            ['show_on_slider', 'boolean'],
            ['text', 'required', 'on' => 'text_required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeLabels()
    {
        return [
            'kurs_id' => 'Kurs',
            'text' => 'Fikr',
            'reply_id' => 'Reply',
            'userRating' => 'Foyd. bahosi',
            'repliesCount' => 'Javoblar soni',
            'show_on_slider' => "Slider ko'rsatish",
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['leave_comment'] = ['text'];
        $scenarios['text_required'] = ['text'];
        return $scenarios;
    }


    /**
     * @return \soft\db\SActiveQuery
     */
    public function getKurs()
    {
        return $this->hasOne(Kurs::className(), ['id' => 'kurs_id']);
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getReply()
    {
        return $this->hasOne(KursComment::className(), ['id' => 'reply_id']);
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(KursComment::className(), ['reply_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getRepliesCount()
    {
        return intval($this->getReplies()->count());
    }

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getRating()
    {
        return $this->hasOne(Rating::class, ['user_id' => 'user_id', 'kurs_id' => 'kurs_id']);
    }

    public static function newCommentsCount()
    {
        return intval(static::find()->andWhere(['status' => self::STATUS_NEW, 'reply_id' => null])->count());
    }

    public static function statuses()
    {
        return [

            self::STATUS_ACTIVE => 'Faol',
            self::STATUS_INACTIVE => 'Nofaol',
            self::STATUS_NEW => 'Yangi',

        ];
    }

    public function getUserRating()
    {
        return $this->rating->rate ?? null;
    }

    public function sendToTelegram()
    {

        $text = "#newcomment\n";
        $title = 'Yangi comment';
        $text .= "<b>$title</b>\n";

        $user = '👤 ' . $this->user->fullname . "\n";
        $kurs = '📝 Kurs: ' . $this->kurs->title . "\n";
        $date = '📅 ' . Yii::$app->formatter->asDateTimeUz($this->created_at) . " \n";
        $comment = "\n $this->text \n";

        $url = Yii::$app->urlManager->createAbsoluteUrl(['/admin/kursmanager/kurs-comment/change-status', 'id' => $this->id, 'status' => 1]);

        $text .= $kurs . $user . $date . $comment . "\nTasdiqlash uchun bosing:\n" . $url;

        $chat_id = Yii::$app->help->virtualdarsTelegramAkkountId();
        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html'
        ]);
    }
}
