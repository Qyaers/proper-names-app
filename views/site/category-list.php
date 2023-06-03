<?php
use yii\widgets\ListView;
use yii\helpers\Html;
$this->title = 'Список категорий имен собственных';

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-category-list"></div>
	<h1><?= Html::encode($this->title) ?></h1>

<?php
echo ListView::widget([
	'dataProvider' => $dataProvider, // переданные данные
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


	'emptyText' => 'Список пуст', // выводим  'Список пуст', если даннах нет
	'emptyTextOptions' => [ // опции для пустого контейнера
		'tag' => 'p' // добавляем тег абзаца для пустого контейнера
	],

	'pager' => [ // постраничная разбивка
		'maxButtonCount' => 5, // количество отображаемых страниц
		'options' => [
			'class' => 'pagination pagination-circle mb-0'],
			'linkOptions' => ['class' => 'btn page-link'],
	],
]);
?>
</div>