<?php

namespace frontend\modules\mbapp\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "temp_number".
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string $phone_number
 * @property string|null $code
 * @property int|null $expired_at
 * @property string $password [varchar(100)]
 */
class TempNumber extends \soft\db\SActiveRecord
{

    const AVAILABLE_SECONDS = 120;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temp_number';
    }

    public static function clearExpired()
    {
       static::deleteAll(['<=', 'expired_at', time()]);
    }

    public function behaviors()
    {
        return [];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_number'], 'required', 'message' => t('Phone number is required.')],
            [['firstname'], 'required', 'message' => t('Firstname is required.')],
            [['password'], 'required', 'message' => t('Password is required.')],
            ['phone_number', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'phone', 'message' => t('This phone number has already been taken')],
            [['expired_at'], 'integer'],
            ['password', 'string', 'min' => 6, 'max' => 100],
            [['firstname', 'lastname', 'phone_number'], 'string', 'max' => 100],
            [['code'], 'integer'],
        ];
    }

/*    public function scenarios()
    {

        $scenarios = parent::scenarios();
        $scenarios['register'] = ['phone_number', ];
    }*/

    public function generateCode()
    {
        $this->code = mt_rand(11111,99999);
        return Yii::$app->sms->sendVerificationCode($this->phone_number, $this->code);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'phone_number' => 'Phone Number',
            'code' => 'Code',
            'expired_at' => 'Expired At',
        ];
    }


    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->status = User::STATUS_ACTIVE;
        $user->phone = $this->phone_number;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateToken();
        if($user->save()){
            $user->sendToTelegramAboutNewUser();
            return $user;
        }
        return false;

    }


}
