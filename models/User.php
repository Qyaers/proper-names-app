<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements \yii\web\IdentityInterface
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

	
	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['acessToken' => $token]);
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUserLogin($login)
	{
		return static::findOne(['login' => $login]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->id;
	}

	public function getUserLogin($login){

		return $this->$login;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return $this->authKey;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return $this->password === $password;
	}

}
?>