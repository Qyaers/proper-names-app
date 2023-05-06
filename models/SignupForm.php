<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{

	public $login;
	public $email;
	public $password;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['login'], 'trim'],
			[['login'], 'required'],
			[['login'], 'unique', 'targetClass' => '\app\models\UserIdentity', 'message' => 'This username has already been taken.'],
			[['login'], 'string', 'min' => 2, 'max' => 255],
			[['email'], 'trim'],
			[['email'], 'required'],
			[['email'], 'email'],
			[['email'], 'string', 'max' => 255],
			[['email'], 'unique', 'targetClass' => '\app\models\UserIdentity', 'message' => 'This email address has already been taken.'],
			[['password'], 'required'],
			[['password'], 'string', 'min' => 6],
	  ];
	}



	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();

			if (!$user || !$user->validatePassword($this->password)) {
					$this->addError($attribute, 'Неверный логин или пароль.');
			}
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 * @return bool whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
		}
		return false;
	}

	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	public function getUser()
	{
		if ($this->_user === false) {
			$this->_user = UserIdentity::findByUserLogin($this->login);
		}

		return $this->_user;
	}
}