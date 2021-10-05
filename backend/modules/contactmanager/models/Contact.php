<?php

namespace backend\modules\contactmanager\models;

use soft\db\SActiveQuery;
use soft\db\SActiveRecord;
use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $firstname
 * @property string $email
 * @property string $body
 * @property int $status
 * @property int $created_at
 * @property string|null $lastname
 * @property-read string $statusLabel
 * @property-read int $isNew
 * @property-read string $markAsReadButton
 * @property-read string $fullname
 * @property string|null $phone
 */
class Contact extends SActiveRecord
{

    public const STATUS_NEW = 1;
    public const STATUS_READ = 0;

    public static function tableName()
    {
        return 'contact';
    }

    public $captcha;

    public function rules()
    {
        return [
            [['firstname'], 'required'],
            [['body'], 'required', 'message' => t('You did not write any messages!')],
            [['body'], 'string'],
            ['email', 'email'],
            [['status', 'created_at'], 'integer'],
            [['firstname', 'email', 'lastname', 'phone'], 'string', 'max' => 255],
            [['captcha'], 'captcha'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['change-status'] = ['status'];
        $scenarios['delete'] = ['status'];
        return $scenarios;
    }

    public function setAttributeLabels()
    {
        return [
            'firstname' => 'Ism',
            'lastname' => 'Familiya',
            'phone' => 'Telefon',
            'email' => 'Email',
            'body' => 'Xabar',
        ];
    }

    public function setAttributeNames()
    {
        return [
            'multilingualAttributes' => [],
            'createdByAttribute' => false, // 'user_id',
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => false, //'updated_at',
        ];
    }

    public static function find()
    {
        $query = new SActiveQuery(get_called_class());
        return $query;
    }

    public function getIsNew()
    {
        return $this->status == self::STATUS_NEW;
    }

    public function getStatusLabel()
    {
        if ($this->isNew) {
            return '<label class="label label-danger">Yangi</label>';
        } else {
            return '<label class="label label-info">Ko\'rildi</label>';
        }
    }

    public function markAsRead()
    {
        if ($this->isNew) {
            $this->scenario = 'change-status';
            $this->status = self::STATUS_READ;
            $this->save();
        }
    }

    public function getMarkAsReadButton()
    {
        if ($this->isNew) {
            return a(fa('check'), ['mark-as-read', 'id' => $this->id], [
                'class' => 'btn btn-sm btn-primary',
                'title' => "O'qilgan sifatida belgilash",

                'data-pjax' => 0,
//                'role' => 'modal-remote',
            ]);
        }
        return '';
    }

    public static function newMessagesCount()
    {
        return intval(static::find()->andWhere(['status' => self::STATUS_NEW])->count());
    }

    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * Yangi xabar yozilganda telegramga jo'natish
     */
    public function sendToTelegram()
    {
        $text = "#newmessage  #contact\n";


        $title = '<b>Yangi xabar</b>';
        $text .= "$title\n";

        $fullname = $this->fullname ? '<b>👤 ' . $this->fullname . "</b>\n" : '';
        $phone = $this->phone ? '☎ ' . $this->phone . "\n" : '';
        $email = $this->email ? '📧 ' . $this->email . "\n" : '';
        $date = '📅 ' . Yii::$app->formatter->asDateTimeUz($this->created_at) . "\n";

        $message = "\n" . $this->body;

        $text .=  $fullname . $phone . $email . $date . $message;

        $chat_id = Yii::$app->help->virtualdarsTelegramAkkountId();
        Yii::$app->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html'
        ]);
    }

}
