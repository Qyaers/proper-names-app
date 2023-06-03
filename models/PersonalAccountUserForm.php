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
			['login', 'trim'],
			['login', 'required'],
			['login', 'string', 'min' => 2, 'max' => 255],
			['email', 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['password', 'required'],
			['password', 'string', 'min' => 6],
	];
	}

	public function getProperNamesByUserId($userId){
		return ProperName::find()->where(['user_id' => $userId])->all();
	}

	public function updateUserData($userId,$login,$password,$email){
		
		if (!$this->validate()) {
			return null;
		}
		$user = new User();
		$user->login = $login;
		$user->password = Yii::$app->security->generatePasswordHash($password);
		$user->email = $email;

		return \Yii::$app->db->createCommand()
		->update('User', [
			'login' => $user->login, 'password'=> $user->password,
			'email'=> $user->email,'role'=> $user->role
		],"id = $userId")
		->execute() ? $user : null;;
		
	}

	public function editUserRequest($data){
		try {
				return Yii::$app->db->createCommand()
				->update('PropersNames', ['name' => $data['name'],'description' => $data['description']], ['id' => $data['id']])
				->execute();
		} catch (\yii\db\Exception $e) {
				return null;
		}
	}

	public function removeProperName($deletedId){
		$deleteArray = $deletedId;
		$deleted = $error = false;
		foreach ($deleteArray as $idDel) {
			if(ProperName::findOne($idDel)->delete()) {
				$deleted = true;
			} else {
				$error = true;
				break;
			}
		}
		if ($deleted && !$error) {
			$res = [
				"message" => "Selected element was terminated",
				"status" => "ok"
			];
		} else {
			$res = [
				"message" => "Error in query.",
				"status" => "error"
			];
		}
		return json_encode($res);
	}
}