<?php

namespace app\models;

use Yii;
use yii\base\Model;

class PersonalAccountUserForm extends Model
{

	public $userId;
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

	public function getProperNamesByUserId($userId){
		return ProperName::find()->where(['user_id' => $userId])->all();
	}

	public function updateUserData(){
		
		if (!$this->validate()) {
			return null;
		}
		$user = User::findOne($userId);
		$user->login = $login;
		$user->password = $password;
		$user->email = $email;
		return $user->save() ? $user : null;
	}
}