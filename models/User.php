<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord
{

	public static function tableName() {
		return 'User';
	}

	public function rules () {
		return [
			[['login','password','email'],'required'],
			[['login'],'string','max '=>15],
			[['password','email','accesToken','authKey',],'string','max '=>32],
		];
	}

	public function attributeLabels() {
		return [
			'id',
			'login',
			'password',
			'email',
			'role',
			'acessToken',
			'authKey',
		];
	}
}
?>