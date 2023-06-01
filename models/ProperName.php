<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class ProperName extends ActiveRecord 
{

	public static function tableName() {
		return 'PropersNames';
	}

	public function rules () {
		return [
			[['name','description'],'required'],
		];
	}

	public function attributeLabels() {
		return [
			'id',
			'name',
			'description',
			'aproved',
			'user_id',
			'category_id',
		];
	}

	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	public static function findByProperName($name)
	{
		return static::findOne(['name' => $name]);
	}

	public static function findByCategoryId($category_id)
	{
		return static::findOne(['category_id' => $category_id]);
	}

	public static function findByDescription($description)
	{
		return static::findOne(['description' => $description]);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getProperName($name){

		return $this->$name;
	}

	public function getDescription($description){

		return $this->$description;
	}
	public function getCategoryId($category_id){

		return $this->$category_id;
	}

	public function getAllProperNames(){
		return ProperName::find();
	}

	public function edit($data){

		$properName = new ProperName();
		$properName->id = $data['id'];
		$properName->name = $data['name'];
		$properName->description = $data['description'];
		$properName->aproved = $data['aproved'];
		$properName->user_id = $data['user_id'];
		$properName->category_id = $data['category_id'];
		
		return \Yii::$app->db->createCommand()
		->update('PropersNames', [
			'name' => $properName->name, 'description'=> $properName->description,
			'aproved'=> $properName->aproved,'user_id'=> $properName->user_id,
			'category_id'=> $properName->category_id,
		],"id = $properName->id")
		->execute();
	}

	public function remove($deletedId){
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

	public function add($data){
		if (ProperName::findOne(["name" => $data['name']] || ProperName::findOne(["description" => $data['description']]))) {
			return null;
		} else{
			$properName = new ProperName();
			$properName->name = $data['name'];
			$properName->description = $data['description'];
			$properName->aproved = $data['aproved'];
			$properName->user_id = $data['user_id'];
			$properName->category_id = $data['category_id'];
			$properName->save();
			return ProperName::findOne(['name' => $data['name']]);
		}
	}
}
?>