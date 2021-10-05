<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 *
 * @property-read string $clearPhone
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $firstname;
    public $lastname;
    public $password;
    public $password_repeat;
    public $phone;
    public $captcha;
    public $code;

    private $verificationDuration = 300; // seconds

    //<editor-fold desc="Overritten methods" defaultstate="collapsed">

    public function rules()
    {
        return [
 /*           ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 5, 'max' => 255],
            ['username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/'],*/

            [['firstname', 'lastname'], 'string', 'min' => 2, 'max' => 255],
            [['firstname'], 'required', 'message' => t('Firstname is required.')],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['password'], 'required', 'message' => t('Password is required.')],
            [['password_repeat'], 'required', 'message' => t('This field is required.')],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => t('The re-entered password does not match')],

            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'match', 'pattern' => '/\+998\(\d{2}\) \d{3}\-\d{2}\-\d{2}/', 'message' => t('Incorrect phone number')],

            ['phone', 'checkPhone'],

            ['code', 'required', 'message' => t('Enter the code')],
            ['code', 'integer'],
            ['code', 'checkCode'],

            ['captcha', 'required', 'message' => t('This field is required.')],
            ['captcha', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => t('Your phone number'),
            'username' => t('Login'),
            'firstname' => t('Your firstname'),
            'lastname' => t('Your lastname'),
            'password' => t('Password'),
            'password_repeat' => t('Enter the password again'),
            'code' => t('Code'),

        ];
    }

/*    public function attributeHints()
    {
        return [
            'phone' => t('Enter your phone number to register'),
        ];
    }*/

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['phone'] = ['phone'];
        $scenarios['verifyPhone'] = ['code'];
        $scenarios['register'] = [ 'firstname', 'lastname', 'password', 'password_repeat'];
        return $scenarios;
    }

    // </editor-fold>

    //<editor-fold desc="Custom methods" defaultstate="collapsed">

    /**
     * Telefon raqamni qo'shimcha belgilardan tozalash,
     * masalan: +998(99) 123-45-67 => 998991234567
     * @return string cleared phone number
     */
    public function getClearPhone()
    {
        return Yii::$app->help->clearPhoneNumber($this->phone);
    }

    // </editor-fold>

    //<editor-fold desc="Step 1: Enter and check phone number, send code via sms" defaultstate="collapsed">

    /**
     * Kiritilgan tel. raqam bazada bor yoki yo'qligini tekshirish
     * Agar mavjud bo'lsa, false qaytaradi
     */
    public function checkPhone()
    {
        $phone = $this->getClearPhone();
        if ($phone != ''){
            $user = User::findOne(['phone' => $phone]);
            if ($user == null){
                return true;
            }
            else{
                $this->addError('phone', 'Ushbu telefon raqam avvalroq band qilingan');
            }
        }
        return false;
    }

    /**
     * Tel. raqam to'g'ri kiritilgandan keyin, ixtiyoriy kodni generatsiya qilish
     *  va kodni sms orqali jo'natish
     */
    public function generateCode()
    {
        $code = mt_rand(10000, 99999);
        if ($this->sendCodeViaSms($code)){

            Yii::$app->session->set('_signup_phone_number', $this->phone);
            Yii::$app->session->set('_signup_verification_code', $code);
            Yii::$app->session->set('_signup_verification_time', time());
            return true;
        }
        return false;
    }

    /**
     * Kodni sms orqali jo'natish
     */
    public function sendCodeViaSms($code)
    {
        return Yii::$app->sms->sendVerificationCode($this->getClearPhone(), $code);
    }

    // </editor-fold>

    //<editor-fold desc="Step 2: Verify phone number via code" defaultstate="collapsed">

    public function checkCode()
    {

        $code = Yii::$app->session->get('_signup_verification_code', false);

        if (!$code || $code != $this->code ){
            $this->addError('code', t('Invalid verification code'));
            return false;
        }

        if ( $this->isVerificationCodeExpired() ){
            $this->addError('code', t('Verification code has been expired'));
            return false;
        }

        return true;

    }

    /**
     * Kodni kiritish vaqti tugagan yoki tugamaganligini tekshirish
     */
    public function isVerificationCodeExpired()
    {
        $time = Yii::$app->session->get('_signup_verification_time', 0);
        return time() > $time + $this->verificationDuration;
    }

    // </editor-fold>

    //<editor-fold desc="Step 3: Signup user" defaultstate="collapsed">


    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->username = $this->username;
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->status = User::STATUS_ACTIVE;
        $user->phone = $this->getClearPhone();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateToken();
        if($user->save()){
            $user->sendToTelegramAboutNewUser();
            return Yii::$app->user->login($user);
        }
        return false;

    }


    // </editor-fold>
}