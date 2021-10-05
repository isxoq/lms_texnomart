<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 *
 * @property-read null|\common\models\User $user
 */
class LoginForm extends Model
{

    const ALLOWED_ROLE = 'admin';

    public $username;
    public $password;
    public $rememberMe = true;


    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required', 'message' => t('This field is required.')],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],

            // check if user can go admin side
//            ['password', 'checkRole'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Check user role after login.
     * If user can not access goto admin side, the user will be logged out
     * @return bool
     */
    public function checkRole()
    {
       if (!Yii::$app->user->can(self::ALLOWED_ROLE)){
           Yii::$app->user->logout();
           $this->addError('password', 'Incorrect username or password.');
           return false;
       }
       return true;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if(Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0)){
                return $this->checkRole();
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
