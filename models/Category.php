<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * CategoryForm is the model behind the login form.
 *
 * @property-read Category|null $name
 *
 */

class Category extends ActiveRecord
{

	public static function tableName() {
		return 'Category';
	}

	public function rules () {
		return [
			[['name'],'required'],
			[['name'],'string','max '=>15],
		];
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

}
?>