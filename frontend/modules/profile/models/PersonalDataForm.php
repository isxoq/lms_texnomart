<?php

namespace frontend\modules\profile\models;

use common\models\User;
use yii\base\Model;

class PersonalDataForm extends Model

{

    public $firstname;
    public $lastname;
    public $position;
    public $avatar;
    public $bio;
    public $address;
    public $age;
    public $education_level_id;
    public $gender;

    public function rules()
    {
        return [
            [['firstname', 'lastname', 'position', 'avatar'], 'string', 'max' => 255],
            [['bio', 'address'], 'string'],
            [['age', 'education_level_id'], 'integer'],
            ['gender', 'in', 'range' => [User::GENDER_MALE, User::GENDER_FEMALE]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'firstname' => t("Your firstname"),
            'lastname' => t("Your lastname"),
            'position' => t('Your position'),
            'avatar' => t('Image'),
            'bio' => t('Information about yourself'),
            'address' => t('Your address'),
            'age' => "Yoshingiz",
            'gender' => "Jinsingiz",
            'education_level_id' => "Ta'lim darajangiz",
        ];
    }

    public static function createUserModel()
    {
        $user = user();
        if (!$user) {
            forbidden();
        } else {

            return new PersonalDataForm([

                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'position' => $user->position,
                'avatar' => $user->avatar,
                'bio' => $user->bio,
                'address' => $user->address,
                'age' => $user->age,
                'education_level_id' => $user->education_level_id,
                'gender' => $user->gender,

            ]);
        }
    }

    public function saveUserData()
    {

        $user = user();
        if (!$user) {
            forbidden();
        }

        if (!$this->validate()) {
            return false;
        }

        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->position = $this->position;
        $user->avatar = $this->avatar;
        $user->bio = $this->bio;
        $user->address = $this->address;
        $user->age = $this->age;
        $user->education_level_id = $this->education_level_id;
        $user->gender = $this->gender;

        return $user->save();

    }


}