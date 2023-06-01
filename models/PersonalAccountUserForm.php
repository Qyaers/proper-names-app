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

	public function updateUserData($userId,$login,$password,$email){
		
		if (!$this->validate()) {
			return null;
		}
		$user = User::findOne($userId);
		$user->login = $login;
		$user->password = $password;
		$user->email = $email;
		return $user->save() ? $user : null;
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