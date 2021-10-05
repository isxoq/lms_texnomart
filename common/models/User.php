<?php

namespace common\models;

use backend\models\Certificate;
use backend\models\EducationLevel;
use backend\modules\usermanager\models\TeacherInfo;
use Yii;
use soft\db\SActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\IdentityInterface;
use soft\behaviors\EnsureUniqueBehavior;
use soft\behaviors\InvalidateCacheBehavior;
use backend\modules\kursmanager\models\Enroll;
use backend\modules\ordermanager\models\Order;
use frontend\models\Kurs;

/**
 * User model
 *
 * @property int $id [int(11)]
 * @property string $username [varchar(255)]
 * @property string $auth_key [varchar(32)]
 * @property string $password_hash [varchar(255)]
 * @property string $email [varchar(255)]
 * @property int $status [smallint(6)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 * @property string $firstname [varchar(255)]
 * @property string $lastname [varchar(255)]
 * @property string $phone [varchar(100)]
 * @property-write string $password
 * @property-read string $authKey
 * @property string|null $bio
 * @property string|null $address
 * @property bool $deleted [tinyint(2)]
 * @property string $type [varchar(50)]
 * @property string $wish_list
 * @property string $watch_history
 * @property string $uid [varchar(50)]
 * @property string $avatar [varchar(255)]
 * @property string $password_md5 [varchar(255)]
 * @property string $position lavozim
 * @property int $age [int]
 * @property int $education_level_id [int]
 * @property bool $gender [tinyint(1)]
 * @property-read string $statusLabel
 * @property-read string $fullname
 * @property-read Order[] $orders
 * @property-read Kurs[] $enrolledCourses
 * @property-read Kurs[] $activeEnrolledCourses
 * @property-read Enroll[] $enrolls
 * @property-read Enroll[] $activeEnrolls
 * @property-read string $image
 * @property-read bool $isSimpleUser
 * @property string $zipcode [varchar(50)]
 * @property bool $isTeacher
 * @property-read EducationLevel $educationLevel
 * @property-read null $educationLevelName
 * @property-read mixed $typeName
 * @property-read mixed $genderName
 * @property-read array $wishListAsArray
 * @property int $revenue_percentage [int]
 * @property string $password_reset_token [varchar(255)]
 * @property-read Kurs[] $myFavouriteCourses
 * @property-read mixed $percentageLabel
 * @property-read bool $hasPhone
 * @property string $token [varchar(150)]
 * @property string $Host [char(60)]
 * @property string $User [char(32)]
 * @property string $Select_priv [enum('N', 'Y')]
 * @property string $Insert_priv [enum('N', 'Y')]
 * @property string $Update_priv [enum('N', 'Y')]
 * @property string $Delete_priv [enum('N', 'Y')]
 * @property string $Create_priv [enum('N', 'Y')]
 * @property string $Drop_priv [enum('N', 'Y')]
 * @property string $Reload_priv [enum('N', 'Y')]
 * @property string $Shutdown_priv [enum('N', 'Y')]
 * @property string $Process_priv [enum('N', 'Y')]
 * @property string $File_priv [enum('N', 'Y')]
 * @property string $Grant_priv [enum('N', 'Y')]
 * @property string $References_priv [enum('N', 'Y')]
 * @property string $Index_priv [enum('N', 'Y')]
 * @property string $Alter_priv [enum('N', 'Y')]
 * @property string $Show_db_priv [enum('N', 'Y')]
 * @property string $Super_priv [enum('N', 'Y')]
 * @property string $Create_tmp_table_priv [enum('N', 'Y')]
 * @property string $Lock_tables_priv [enum('N', 'Y')]
 * @property string $Execute_priv [enum('N', 'Y')]
 * @property string $Repl_slave_priv [enum('N', 'Y')]
 * @property string $Repl_client_priv [enum('N', 'Y')]
 * @property string $Create_view_priv [enum('N', 'Y')]
 * @property string $Show_view_priv [enum('N', 'Y')]
 * @property string $Create_routine_priv [enum('N', 'Y')]
 * @property string $Alter_routine_priv [enum('N', 'Y')]
 * @property string $Create_user_priv [enum('N', 'Y')]
 * @property string $Event_priv [enum('N', 'Y')]
 * @property string $Trigger_priv [enum('N', 'Y')]
 * @property string $Create_tablespace_priv [enum('N', 'Y')]
 * @property string $ssl_type [enum('', 'ANY', 'X509', 'SPECIFIED')]
 * @property string $ssl_cipher [blob]
 * @property string $x509_issuer [blob]
 * @property string $x509_subject [blob]
 * @property int $max_questions [int(11) unsigned]
 * @property int $max_updates [int(11) unsigned]
 * @property int $max_connections [int(11) unsigned]
 * @property int $max_user_connections [int(11) unsigned]
 * @property string $plugin [char(64)]
 * @property string $authentication_string
 * @property int $password_last_changed [timestamp]
 * @property int $password_lifetime [smallint(5) unsigned]
 * @property string $account_locked [enum('N', 'Y')]
 * @property-read Certificate[] $certificates
 * @property-read TeacherInfo $teacherInfo
 * @property string $password_expired [enum('N', 'Y')]
 */
class User extends SActiveRecord implements IdentityInterface
{

    use UserTrait;
    use UserTelegramTrait;

    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public const TYPE_USER = 'user';
    public const TYPE_TEACHER = 'teacher';

    /**
     * @var array
     */
    private $_wishListAsArray;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return string[]
     */
    public static function types()
    {
        return [
            self::TYPE_USER => 'Talaba',
            self::TYPE_TEACHER => "O'qituvchi",
        ];
    }

    /**
     * @return mixed
     */
    public function getTypeName()
    {
        return ArrayHelper::getValue(self::types(), $this->type);
    }

    /**
     * @return string[]
     */
    public static function genders()
    {
        return [
            self::GENDER_MALE => 'Erkak',
            self::GENDER_FEMALE => 'Ayol',
        ];
    }

    /**
     * @return mixed
     */
    public function getGenderName()
    {
        return ArrayHelper::getValue(self::genders(), $this->gender);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
            [
                'class' => TimestampBehavior::class,
            ],
            [
                'class' => EnsureUniqueBehavior::class,
            ],
            [
                'class' => InvalidateCacheBehavior::class,
                'tags' => 'user',
            ]
        ];


    }

    public function setAttributeLabels()
    {
        return [

            'firstname' => 'Ism',
            'lastname' => 'Familiya',
            'phone' => 'Telefon raqam',
            'fullName' => 'Ism-Familiya',
            'age' => 'Yosh',
            'percentageLabel' => "O'qituvchi ulushi",
            'revenue_percentage' => "O'qituvchi ulushi",
            'address' => 'Manzil',
            'gender' => 'Jinsi',
            'position' => 'Lavozim',
            'education_level_id' => "Ta'lim darajasi",
            'educationLevelName' => "Ta'lim darajasi",
            'educationLevel.name' => "Ta'lim darajasi",
            'type' => 'Foydalanuvchi roli',
            'typeName' => 'Foydalanuvchi roli',
            'password' => 'Parol',

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            ['type', 'default', 'value' => self::TYPE_USER],
            ['type', 'in', 'range' => [self::TYPE_USER, self::TYPE_TEACHER]],

            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],

            ['revenue_percentage', 'integer', 'max' => 100, 'min' => 0],
            ['username', 'unique'],

            [['username', 'email', 'firstname', 'lastname', 'position', 'avatar'], 'string', 'max' => 255],
            ['email', 'unique'],
            ['email', 'email'],

            [['age', 'education_level_id'], 'integer'],

            ['phone', 'string'],

            [['bio', 'address'], 'string'],
            ['password_hash', 'safe'],

            [['firstname'], 'required'],
            [['firstname', 'lastname'], 'string', 'min' => 3],

            ['revenue_percentage', 'default', 'value' => 70],
            ['revenue_percentage', 'integer', 'min' => 1, 'max' => 100],

        ];
    }

    public function scenarios()
    {
        $s = parent::scenarios();
        $s['updatePersonalData'] = ['firstname', 'lastname',];
        $s['change-password'] = ['password_hash'];
        $s['create-by-teacher'] = ['phone', 'firstname', 'lastname', 'password', 'email'];
        return $s;
    }

    //<editor-fold desc="Required methods" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if ($this->password_hash == null) {
            if (sha1($password) == $this->password_md5) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($password);
                $this->password_md5 = null;
                $this->save();
                return true;
            } else {
                return false;
            }
        }
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates "token" for mobile app
     */
    public function generateToken()
    {
        $token = Yii::$app->security->generateRandomString() . '_' . time();
        $user = static::findOne(['auth_key' => $token]);
        while ($user != null) {
            $token = Yii::$app->security->generateRandomString() . '_' . time();
            $user = static::findOne(['token' => $token]);
        }
        $this->token = $token;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

// </editor-fold>

    /**
     * @param $phoneNumber
     * @return \common\models\User|null
     */
    public static function findByPhoneNumber($phoneNumber)
    {
        return static::findOne(['phone' => $phoneNumber, 'status' => User::STATUS_ACTIVE]);
    }

    /**
     * Userni o'qituvchi qilish
     * @return bool
     */
    public function makeTeacher()
    {
        $this->type = self::TYPE_TEACHER;
        return $this->save(false);
    }

    /**
     * Userdan o'qituvchilik huquqini olib tashlash
     * @return bool
     */
    public function removeTeacher()
    {
        $this->type = self::TYPE_USER;
        return $this->save(false);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationLevel()
    {
        return $this->hasOne(EducationLevel::class, ['id' => 'education_level_id']);
    }

    /**
     * @return string|null
     */
    public function getEducationLevelName()
    {
        return $this->educationLevel->name ?? null;
    }


    //<editor-fold desc="Wishlist" defaultstate='collapsed'>


    /**
     * @return array
     */
    public function getWishListAsArray()
    {
        if ($this->_wishListAsArray == null) {
            $wishlist = Json::decode($this->wish_list);
            if (!is_array($wishlist)) {
                $wishlist = [];
            }
            $this->setWishListAsArray($wishlist);
        }
        return $this->_wishListAsArray;
    }

    public function setWishListAsArray($wishlist = [])
    {
        $this->_wishListAsArray = $wishlist;
    }

    /**
     * @param $id int Kurs id raqami
     * @return bool
     */
    public function addToWishList($id)
    {
        $wishlist = $this->wishListAsArray;
        if (!in_array($id, $wishlist)) {
            $wishlist[] = $id;
        }
        $this->wish_list = Json::encode($wishlist);
        if ($this->save(false)) {
            $this->setWishListAsArray($wishlist);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id int Kurs id raqami
     * @return bool
     */
    public function removeFromWishList($id)
    {
        $wishlist = $this->wishListAsArray;
        $key = array_search($id, $wishlist);
        if ($key !== false) {
            unset($wishlist[$key]);
        }
        $this->wish_list = Json::encode($wishlist);
        if ($this->save(false)) {
            $this->setWishListAsArray($wishlist);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Berilgan id raqamidagi kurs Userning wishlistiga qo'shilgan bo'lsa true, aks holda false qaytaradi
     * @param $id int Kurs id raqami
     * @return bool
     */
    public function isWish($id)
    {
        return in_array($id, $this->wishListAsArray);
    }

    public function getMyFavouriteCourses()
    {
        return Kurs::find()->andWhere(['in', 'id', $this->wishListAsArray])->active()->all();
    }

    //</editor-fold>


    public function getPercentageLabel()
    {
        return Yii::$app->formatter->asPercent($this->revenue_percentage / 100);
    }

    /**
     * @return bool
     */
    public function getHasPhone()
    {
        return !empty($this->phone);
    }


    public function getCertificates()
    {
        return $this->hasMany(Certificate::class, ['user_id' => 'id']);
    }

    //<editor-fold desc="Teacher info" defaultstate="collapsed">

    /**
     * @return \soft\db\SActiveQuery
     */
    public function getTeacherInfo()
    {
        return $this->hasOne(TeacherInfo::class, ['user_id' => 'id']);
    }

    /**
     * @return \backend\modules\usermanager\models\TeacherInfo
     */
    public function findOrCreateTeacherInfo()
    {
        return $this->teacherInfo ?? (new TeacherInfo(['user_id' => $this->id]));
    }

    //</editor-fold>
}