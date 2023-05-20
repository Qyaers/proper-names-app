<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Category	|null $user
 *
 */
class ProperNameForm extends Model
{
	public $id;
	public $name;
	public $сategory_id;
	public $description;
	public $user_id;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			['name','required','message' => 'Поле "Наименование" должно быть заполнено.'],
			['name', 'unique' ,'targetClass' => '\app\models\ProperName' , 'message' => 'Такая категория уже существует'],
			['description','unique','targetClass' => '\app\models\ProperName' , 'message' => 'Такое описание уже существует'],
			['user_id','number'],
			['category_id','number']
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

	public function getCategoryId($name){
		return Category::find()
		->where(['name' => $name])
		->one();;
	}

}
