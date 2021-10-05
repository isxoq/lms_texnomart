<?php


namespace backend\modules\profilemanager\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{

    public $password;
    public $repassword;

    public function rules()
    {
        return [

            [['password',], 'string', 'min' => 5, 'max' => 255],
            [['repassword'], 'string',  'max' => 255],
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
        $model = ProfileUser::findOne(Yii::$app->user->identity->id);
        $model->scenario = 'change-password';
        $model->password_hash = $newPassword;
        return  $model->save();
    }

}