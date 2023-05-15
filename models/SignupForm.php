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
			[['login','email'], 'trim'],
			[['login','email','password'], 'required'],
			[['login'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
			[['email'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
	];
	}

	public function signup()
	{

			if (!$this->validate()) {
				return null;
			}

			$user = new User();
			$user->login = $this->login;
			$user->email = $this->email;
			$user->password = $this->password;
			return Yii::$app->db->createCommand('INSERT INTO `User` (`login`,`email`,`password`) VALUES (:login,:email,:password)', [
							':login' => $user->login,
							':email' => $user->email,
							':password' => $user->password
						])->execute() ? $user : null;
	}
}