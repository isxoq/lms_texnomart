<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 *
 * @property-read null|string $errorMessage the first error message
 * @property-read null|User $user
 */
class LoginForm extends Model
{
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

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => t('Login'),
            'password' => t('Password'),
            'rememberMe' => t('Remember me')
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
                $this->addError($attribute, t('Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->generateAuthKey();
            $user->save(false);
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
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

            $user = User::findOne(['email' => $this->username, 'status' => User::STATUS_ACTIVE]);
            if ($user == null){

                $username = $this->normalizePhoneNumber($this->username);
                $user = User::findOne(['phone' => $username, 'status' => User::STATUS_ACTIVE]);
            }
            $this->_user = $user;
        }

        return $this->_user;
    }

    /**
     * @param null|string $phoneNumber
     * @return mixed|string|null
     */
    private function normalizePhoneNumber($phoneNumber=null)
    {
        $phoneNumber = Yii::$app->help->clearPhoneNumber($phoneNumber);
        $length = strlen($phoneNumber);
        if ($length == 9){
            return "998".$phoneNumber;
        }
        return $phoneNumber;
    }

    public function getErrorMessage()
    {
        $firstErrors = $this->getFirstErrors();
        if (empty($firstErrors)){
            return null;
        }
        $values = array_values($firstErrors);
        return $values[0];
    }
}

