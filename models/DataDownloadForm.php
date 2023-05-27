<?php

namespace app\models;

use Yii;
use yii\base\Model;

class DataDownloadForm extends Model
{
	public $category_id;
	public $category_name;
	
	public function rules()
	{
		return [
			[['category_id'], 'required'],
			[['category_id'],'number'],
			[['category_name'],'string'],

		];
	}
	public function getProperNamesByCategoryId($category_id){
		
		return ProperName::find()->select(['name','description'])->where(['category_id' => $category_id])->all();
	}
}
