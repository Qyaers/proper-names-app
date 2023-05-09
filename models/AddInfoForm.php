<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class AddInfoForm extends Model
{
	public $id;
	public $name;
	public $ancestor;

	public function rules()
	{
		return [
			[[['name'], ['id']], 'required'],
		];
	}
	
}