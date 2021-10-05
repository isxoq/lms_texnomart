<?php

namespace backend\modules\usermanager\models;

use backend\modules\kursmanager\models\Kurs;
use common\models\UserTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property-read Kurs[] $courses
 * @property-read TeacherApplication[] $teacherApplications
 */
class User extends \common\models\User
{

    public $password;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['password'], 'required', 'on' => ['create', 'create-by-teacher']];
        $rules[] = ['password', 'string', 'min' => 5];
        $rules[] = ['phone', 'string'];
        $rules[] = ['phone', 'unique'];
        $rules[] = [['phone'], 'required' ];
        return $rules;
    }

    public function getTeacherApplications()
    {
        return $this->hasMany(TeacherApplication::className(), ['user_id' => 'id']);
    }

    public function getCourses()
    {
        return $this->hasMany(Kurs::class, ['user_id' => 'id']);
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }

        $this->generateAuthKey();
        $this->generateToken();

        $this->phone = Yii::$app->help->clearPhoneNumber($this->phone);
        if (empty($this->email)) {
            $this->email = null;
        }
        return true;

    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (!empty($this->password_hash)) {
            $this->password_md5 = null;
        }
        return true;
    }


}
