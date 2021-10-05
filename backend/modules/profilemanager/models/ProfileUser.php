<?php

namespace backend\modules\profilemanager\models;

use soft\db\SActiveRecord;

class ProfileUser extends SActiveRecord
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [

            ['username', 'required'],
            ['username', 'unique'],
            [['username', 'email', 'firstname', 'lastname'], 'string',  'max' => 255],
            ['email', 'unique'],
            ['email', 'email'],
            ['password_hash', 'safe'],

        ];
    }

    public function setAttributeLabels()
    {
        return [
            'username' => "Login",
            'firstname' => t("Your name"),
            'lastname' => t("Lastname"),
        ];
    }


    public function scenarios()
    {
        $s = parent::scenarios();
        $s['update'] = ['username', 'email', 'firstname', 'lastname'];
        $s['change-password'] = ['password_hash'];
        return $s;
    }

}