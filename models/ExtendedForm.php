<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ExtendedForm extends Model
{
	public $category;
	public $propName;
	public $categorySearch;
	public $properNameSearch;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['category', 'propName'], 'string'],
			[['category'],'number'],
			[['categorySearch','properNameSearch'], 'boolean'],
		];
	}
}
