<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Category extends ActiveRecord implements \yii\web\IdentityInterface
{

	public static function tableName() {
		return 'Category';
	}

	public function rules () {
		return [
			[['id','name','ancestor'],'required'],
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

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return $this->authKey;
	}

}
?>