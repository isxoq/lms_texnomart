<?php


namespace frontend\modules\profile\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{

    public $password;
    public $repassword;

    public function rules()
    {
        return [

            [['password', 'repassword'], 'string', 'min' => 5, 'max' => 255],
            [['password', 'repassword'], 'required'],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'message' => t('The re-entered password does not match')],

        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => t('New password'),
            'repassword' => t('Repeat new password'),
        ];
    }

    public function savePassword()
    {
        if (!$this->validate()){
            return false;
        }

        $newPassword = Yii::$app->security->generatePasswordHash($this->password);
        $model = Yii::$app->user->identity;
        $model->scenario = 'change-password';
        $model->password_hash = $newPassword;
        return  $model->save();
    }

}