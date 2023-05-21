<?php

namespace app\models;

use yii\db\ActiveRecord;

class ProperName extends ActiveRecord 
{

	public static function tableName() {
		return 'PropersNames';
	}

	public function rules () {
		return [
			[['name','discription'],'required'],
			[['name'],'string','max '=>15],
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
}
?>