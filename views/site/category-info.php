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
				'dataProvider' => $subCategory, // переданные данные
				'itemView' => 'list-category-item',// шаблон для вывода данных

				'options' => [ // настройка атрибутов для внешнего контейнера списка
					'tag' => 'div', // заключаем сипсок в блок div
					'class' => 'category-list', // класс блока div
					'id' => 'category-list', // идентификатор блока div
				],
				'itemOptions' => [ // опции для списка
					'tag' => 'div', // заключаем список в тег div
					'class' => 'category'
				],

				'emptyText' => 'Подкатегории отсутствуют', // выводим  'Список пуст', если даннах нет
				'emptyTextOptions' => [ // опции для пустого контейнера
					'tag' => 'p', // добавляем тег абзаца для пустого контейнера
					'class' => 'empty-info'
				],

				'pager' => [ // постраничная разбивка
					'firstPageLabel' => 'Первая', // ссылка на первую страницу
					'lastPageLabel' => 'Последняя', // ссылка на последнюю странцу
					'maxButtonCount' => 5, // количество отображаемых страниц
				],
			]);
		}?>
	</div>
	<div>
		<?php  
		if($propNames){
			echo "<h2 class='mt-3'>Имена собственные выбранной категории</h2>";
			
			echo ListView::widget([
				'dataProvider' => $propNames, // переданные данные
				'itemView' => 'list-proper-names-item',// шаблон для вывода данных

				'options' => [ // настройка атрибутов для внешнего контейнера списка
					'tag' => 'div', // заключаем сипсок в блок div
					'class' => 'proper-names__list', // класс блока div
					'id' => 'proper-names__list', // идентификатор блока div
				],
				'itemOptions' => [ // опции для списка
					'tag' => 'div', // заключаем список в тег div
					'class' => 'proper-names'
				],

				'emptyText' => 'Имена собственные отсутствуют', // выводим  'Список пуст', если даннах нет
				'emptyTextOptions' => [ // опции для пустого контейнера
					'tag' => 'p', // добавляем тег абзаца для пустого контейнера
					'class' => 'empty-info'
				],

				'pager' => [ // постраничная разбивка
					'firstPageLabel' => 'Первая', // ссылка на первую страницу
					'lastPageLabel' => 'Последняя', // ссылка на последнюю странцу
					'maxButtonCount' => 5, // количество отображаемых страниц
					'options' => [
						'class' => 'pagination pagination-circle pg-blue mb-0'],
						'linkOptions' => ['class' => 'page-link'],
				],
			]);
		}?>
	</div>
</div>
