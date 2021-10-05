<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\validators\EmailValidator;

/**
 * Password reset request form
 *
 * @property mixed $clearedPhoneNumber
 * @property User $user
 * @property mixed $type
 */
class PasswordResetRequestForm extends Model
{

    const EXPIRED_SECONDS = 300;

    const TYPE_EMAIL = 'email';
    const TYPE_PHONE = 'phone';

    private $_type;
    private $_clearedPhoneNumber;
    private $_user;

    /**
     * @var string phone number or email of user
     */
    public $phone;
    public $code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'safe'],
            ['phone', 'string'],
            ['phone', 'match', 'pattern' => '/\+998\(\d{2}\) \d{3}\-\d{2}\-\d{2}/', 'message' => t('Incorrect phone number')],

            ['code', 'integer'],
            ['code', 'required'],
            ['code', 'match', 'pattern' => '/\d{5}/', 'message' => t('Incorrect verification code')],

        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => t('Phone number')
        ];
    }

    public function scenarios()
    {
        $s = parent::scenarios();
        $s['phone'] = ['phone'];
        $s['code'] = ['code'];
        return $s;
    }

    //<editor-fold desc="Setters and Getters" defaultstate="collapsed">

    /**
     * @return User
     */
    public function getUser()
    {
        if ($this->_user == null) {
            $user = null;
            $clearedPhoneNumber = $this->clearedPhoneNumber;
            if (!empty($clearedPhoneNumber) && strlen($clearedPhoneNumber) >= 9 ){
                $user = User::findOne(['phone' => $this->clearedPhoneNumber, 'status' => User::STATUS_ACTIVE]);
            }
            $this->user = $user;
        }
        return $this->_user;
    }

    /**
     * @param User $user
     */
    public function setUser($user): void
    {
        $this->_user = $user;
    }

    /**
     * @return mixed
     */
    public function getClearedPhoneNumber()
    {
        return $this->_clearedPhoneNumber;
    }

    /**
     * @param mixed $clearedPhoneNumber
     */
    public function setClearedPhoneNumber($clearedPhoneNumber): void
    {
        $this->_clearedPhoneNumber = $clearedPhoneNumber;
    }


    //</editor-fold>

    //<editor-fold desc="Step1: Enter phone number and send code via sms" defaultstate="collapsed">


    /**
     * @return mixed|string|null
     */
    public function normalizePhoneNumber()
    {
        $phoneNumber = Yii::$app->help->clearPhoneNumber($this->phone);
        $length = strlen($phoneNumber);
        if ($length == 9) {
            $phoneNumber = "998" . $phoneNumber;
        }
        $this->clearedPhoneNumber = $phoneNumber;
    }

    public function sendSmsMessage()
    {
        if (!$this->validate()) {
            return false;
        }
        $this->normalizePhoneNumber();
        $phoneNumber = $this->clearedPhoneNumber;
        $user = $this->user;
        if ($user == null) {
            $this->addError('phone', t('Incorrect phone number'));
            return false;
        }

        $code = mt_rand(11111, 99999);
        $time = time() + self::EXPIRED_SECONDS;
        $user->password_reset_token = $code . "_" . $time;
        if ($user->save(false)) {
            if (Yii::$app->sms->sendResetCode($phoneNumber, $code)){
                return true;
            }
            else{
                Yii::$app->session->setFlash('error', t('An error occured while sending verification code to your phone number'));
            }
        }
        return false;
    }

    //</editor-fold>

    //<editor-fold desc="Step2: Check Code" defaultstate="collapsed">

    public function explodeResetToken()
    {
        $array = explode('_', $this->user->password_reset_token);
        if (!is_array($array) || count($array) < 2 ){
            return false;
        }
        return $array;
    }

    public function isExpired($time)
    {
        return time() > $time;
    }

    public function checkCode($code)
    {
        return $this->code == $code;
    }

    //</editor-fold>

    //<editor-fold desc="Email" defaultstate="collapsed">


    public function checkLogin()
    {
        if (!$this->validate()) {
            return false;
        }
        if ($this->isEmail()) {
            $this->type = self::TYPE_EMAIL;

            /* @var $user User */
            $user = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'email' => $this->phone,
            ]);

            if (!$user) {
                $this->addError('phone', t('Incorrect phone number or email'));
                return false;
            }

            if ($this->sendEmail()) {
                Yii::$app->session->setFlash('success', t('Message for password reset sent to email successfully'));
                return true;
            } else {
                Yii::$app->session->setFlash('success', t('Sorry, we are unable to reset password for the provided email address.'));
                return false;
            }
        } else if ($this->isPhoneNumber()) {
            $this->type = self::TYPE_PHONE;
            return $this->sendSmsMessage();
        }

        return false;


    }

    public function isPhoneNumber()
    {
        $this->normalizePhoneNumber();
        return preg_match('/998\d{9}/', $this->clearedPhoneNumber);
    }

    public function isEmail()
    {
        $model = clone $this;
        $model->clearErrors();
        (new EmailValidator())->validateAttribute($model, 'phone');
        return !$model->hasErrors();
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->phone,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            //            ->compose(
            //                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
            //                ['user' => $user]
            //            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->phone)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->_type = $type;
    }

    //</editor-fold>


}