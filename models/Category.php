<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Category extends ActiveRecord 
{

	public static function tableName() {
		return 'Category';
	}

	public function attributeLabels() {
		return [
			'id',
			'name',
			'ancestor',
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
	 * Finds Category by name
	 *
	 * @param string $name
	 * @return static|null
	 */
	public static function findByCategoryName($name)
	{
		return static::findOne(['name' => $name]);
	}


	public static function findAllByCategoryName($name){
		return static::findAll(['name' => $name]);
	}
		/**
	 * Finds Ancestor by name
	 *
	 * @param string $ancestor
	 * @return static|null
	 */
	public static function findByAncestor($ancestor)
	{
		return static::findOne(['ancestor' => $ancestor]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->id;
	}

	public function getCategoryName($name){

		return $this->$name;
	}


	public function getCategoryAncestor($ancestor){

		return $this->$ancestor;
	}

// TODO Проверить, как работает

	public function getAllCategory(){
		return Category::find();
	}

	public function edit($data){

		$category = new Category();
		$category->id = $data['id'];
		$category->name = $data['name'];
		$category->ancestor = $data['ancestor'];
		
		return \Yii::$app->db->createCommand()
		->update('Category', [
			'name' => $category->name, 'ancestor'=> $category->ancestor
		],"id = $category->id")
		->execute();
	}

	public function remove($deletedId){
		$deleteArray = $deletedId;
		$deleted = $error = false;
		foreach ($deleteArray as $idDel) {
			if(ProperName::deleteAll(["category_id"=>$idDel]));
			if(Category::findOne($idDel)->delete()) {
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
		if (Category::findOne(["name" => $data['name']])) {
			return null;
		} else{
			$category = new Category();
			$category->name = $data['name'];
			$category->ancestor = $data['ancestor'];
			$category->save();
			return Category::findOne(['name' => $data['name']]);
		}
	}
}
?>