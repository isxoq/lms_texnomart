<?php


namespace frontend\models;


use backend\models\EducationLevel;
use yii\base\Model;
use common\models\User;

class BecomeTeacherForm extends Model
{

    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $age;
    public $education_level_id;
    public $gender;
    public $address;
    public $message;
    public $doc;
    public $accept_terms_and_conditions = false;
    public $speciality;
    public $is_ready;

    public function rules()
    {
        return [

            [
                [
                    'firstname', 'lastname', 'age',
                    'education_level_id', 'gender',
                    'address', 'message', 'speciality', 'is_ready'
                ],
                'required',
                'message' => t('This field is required.'),
            ],

            [['firstname', 'lastname'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'email'],

            ['phone', 'string'],

            ['age', 'integer'],

            [['education_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationLevel::className(), 'targetAttribute' => ['education_level_id' => 'id']],

            ['gender', 'in', 'range' => [User::GENDER_MALE, User::GENDER_FEMALE,]],

            [['address', 'message'], 'string'],

            [['doc', 'speciality'], 'string', 'max' => 255],
            ['is_ready', 'boolean'],

            ['accept_terms_and_conditions', 'boolean'],
            ['accept_terms_and_conditions', 'required', 'requiredValue' => 1, 'message' => t('This field is required.')]


        ];
    }

    public function attributeLabels()
    {
        return [

            'firstname' => t('Your firstname'),
            'lastname' => t('Your lastname'),
            'message' => t('Information about yourself'),
            'address' => t('Your address'),
            'age' => t('Your age'),
            'speciality' => "Joylamoqchi bo'lgan video darsingiz yo'nalishini kiriting",
            'is_ready' => "Video darslaringiz tayyormi?"

        ];
    }

    /* public function scenarios()
     {
         $scenarios = parent::scenarios();
         $scenarios['apply'] = ['firstname', 'lastname', 'message'];
         return $scenarios;
     }*/

}