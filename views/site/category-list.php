<?php
use yii\widgets\ListView;
use yii\helpers\Html;
$this->title = 'Список категорий имен собственных';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-category-list"></div>
	<h1><?= Html::encode($this->title) ?></h1>
	<code><?= __FILE__ ?></code>

<?php
echo ListView::widget([
	'dataProvider' => $dataProvider, // переданные данные
	'itemView' => 'list-category-item',// шаблон для вывода данных

	'options' => [ // настройка атрибутов для внешнего контейнера списка
		'tag' => 'div', // заключаем сипсок в блок div
		'class' => 'country-list', // класс блока div
		'id' => 'country-list', // идентификатор блока div
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
		'firstPageLabel' => 'Первая', // ссылка на первую страницу
		'lastPageLabel' => 'Последняя', // ссылка на последнюю странцу
		'maxButtonCount' => 5, // количество отображаемых страниц
	],
]);
?>
</div>