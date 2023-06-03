<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use app\models\Category;


$this->title = $title;

if(Yii::$app->request->get('prevTitle') &&  Yii::$app->request->get('prevTitle') != 'Список категорий имен собственных'){
	$id = Category::findOne(['name'=>Yii::$app->request->get('prevTitle')])?Category::findOne(['name'=>Yii::$app->request->get('prevTitle')])->id:null;
	$prevId = Yii::$app->request->get('prevId');
	$prevTitel= Yii::$app->request->get('prevTitle');

	if($prevTitel != 'Список категорий имен собственных'){
		if($prevId){
			$this->params['breadcrumbs'][] = ['label' => $prevTitel,
			'url'=> ["/site/category-info?id=".$prevId." &name=".$prevTitel.""]];
		}
		else{
		$this->params['breadcrumbs'][] = ['label' => $prevTitel,
		'url'=> ["/site/category-info?id=".$id." &name=".$prevTitel.""]];
		}
	}
}
else{
	$this->params['breadcrumbs'][] = ['label' => "Список категорий имен собственных",
	'url'=> ["/site/list-category"]];
}
	$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-category-info">

	<h1><?= Html::encode($this->title) ?></h1>
	<div>
		<?php 
		
		if($subCategory){
			echo "<h2 class='mt-3'>Подкатегории</h2>";
		
			echo ListView::widget([
				'dataProvider' => $subCategory, 
				'itemView' => 'list-category-item',

				'options' => [
					'tag' => 'div',
					'class' => 'category-list',
					'id' => 'category-list', 
				],
				'itemOptions' => [ 
					'tag' => 'div',
					'class' => 'category'
				],

				'emptyText' => 'Подкатегории отсутствуют',
				'emptyTextOptions' => [
					'tag' => 'p',
					'class' => 'empty-info'
				],

				'pager' => [
					'firstPageLabel' => 'Первая',
					'lastPageLabel' => 'Последняя',
					'maxButtonCount' => 5,
				],
			]);
		}?>
	</div>
	<div>
		<?php  
		if($propNames){
			echo "<h2 class='mt-3'>Имена собственные выбранной категории</h2>";
			
			echo ListView::widget([
				'dataProvider' => $propNames, 
				'itemView' => 'list-proper-names-item',

				'options' => [ 
					'tag' => 'div',
					'class' => 'proper-names__list',
					'id' => 'proper-names__list',
				],
				'itemOptions' => [ 
					'tag' => 'div', 
					'class' => 'proper-names'
				],

				'emptyText' => 'Имена собственные отсутствуют', 
				'emptyTextOptions' => [ 
					'tag' => 'p',
					'class' => 'empty-info'
				],

				'pager' => [ 
					'maxButtonCount' => 15, 
					'options' => [
						'class' => 'pagination pagination-circle mb-0'],
						'linkOptions' => ['class' => 'btn page-link'],
				],
			]);
		}?>
	</div>
</div>
