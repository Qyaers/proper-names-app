<?php

namespace app\models;
use Yii;
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
			// [['login'],'string','max '=>15],
			// [['password','email','accesToken','authKey',],'string','max '=>15],
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

	public function getRole()
	{
		return $this->role;
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
		 return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password);

	}

	public function getAllUsers(){
		return User::find();
	}

	public function edit($data){

		$user = new User();
		$user->id = $data['id'];
		$user->login = $data['login'];
		$user->password = Yii::$app->security->generatePasswordHash($data['password']);
		$user->email = $data['email'];
		$user->role = $data['role'];
		$user->authKey = $data['authKey'];

		return \Yii::$app->db->createCommand()
		->update('User', [
			'login' => $user->login, 'password'=> $user->password,
			'email'=> $user->email,'role'=> $user->role, 'authKey'=>$user->authKey
		],"id = $user->id")
		->execute();
	}

	public function remove($deletedId){
		$deleteArray = $deletedId;
		$deleted = $error = false;
		foreach ($deleteArray as $idDel) {
			if(ProperName::deleteAll(["user_id"=>$idDel]));
			if(User::findOne($idDel)->delete()) {
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

	public function add($data){
		if (User::findOne(["name" => $data['name']] || User::findOne(["description" => $data['description']]))) {
			return null;
		} else{
			$user = new User();
			$user->login = $data['login'];
			$user->password = setPassword($data['password']);
			$user->email = $data['email'];
			$user->role = $data['role'];
			$user->authKey = generateAuthKey();
			$user->save();
			return User::findOne(['name' => $user->name]);
		}
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		 $this->password = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		 $this->authKey = Yii::$app->security->generateRandomString();
	}
}
?>