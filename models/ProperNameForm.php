<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ProperNameForm extends Model
{
	public $id;
	public $name;
	public $category_id;
	public $description;
	public $user_id;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['name','description','category_id'],'required','message' => 'Поля должны быть заполнены.'],
			['name', 'unique' ,'targetClass' => '\app\models\ProperName' , 'message' => 'Такое имя собственное уже существует'],
			['description','unique','targetClass' => '\app\models\ProperName' , 'message' => 'Такое описание уже существует'],
			['category_id','number'],
		];
	}

	// TODO сделать для имен собственных они только уникальны
	public function getProperName()
	{
		return ProperName::findByProperName($this->name);
	}

	public function getDescription()
	{
		return ProperName::findByDescription($this->description);
	}

	public function getCategoryId($category_name){
		return Category::find()
		->select('id')
		->where(['name' => $category_name])
		->one();
	}

}
