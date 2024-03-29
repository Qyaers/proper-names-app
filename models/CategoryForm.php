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
class CategoryForm extends Model
{
	public $id;
	public $name;
	public $ancestor;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			['name','required','message' => 'Поле "Наименование" должно быть заполнено.'],
			['name', 'unique' ,'targetClass' => '\app\models\Category' , 'message' => 'Такая категория уже существует'],
			['ancestor','number']
		];
	}

	
	public function getNameCategory()
	{
		return Category::findByCategoryName($this->name);
	}

}
