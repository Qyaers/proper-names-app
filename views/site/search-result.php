<?php
use yii\widgets\ListView;
use yii\helpers\Html;
$this->title = 'Список категорий имен собственных';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-search-result"></div>
	<h1><?= Html::encode($this->title) ?></h1>
	<code><?= __FILE__ ?></code>

<?php
	if(isset($dataProvider)){
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

			'emptyText' => 'Такой категории не нет.', // выводим  'Список пуст', если даннах нет
			'emptyTextOptions' => [ // опции для пустого контейнера
				'tag' => 'p' // добавляем тег абзаца для пустого контейнера
			],

			'pager' => [ // постраничная разбивка
				'firstPageLabel' => 'Первая', // ссылка на первую страницу
				'lastPageLabel' => 'Последняя', // ссылка на последнюю странцу
				'maxButtonCount' => 5, // количество отображаемых страниц
			],
		]);
	}
	else{
		echo ListView::widget([
			'dataProvider' => $propNames, // переданные данные
			'itemView' => 'list-proper-names-item',// шаблон для вывода данных

			'options' => [ // настройка атрибутов для внешнего контейнера списка
				'tag' => 'div', // заключаем сипсок в блок div
				'class' => 'category-list', // класс блока div
				'id' => 'category-list', // идентификатор блока div
			],
			'itemOptions' => [ // опции для списка
				'tag' => 'div', // заключаем список в тег div
				'class' => 'category'
			],

			'emptyText' => 'Такого имени собственного нет.', // выводим  'Список пуст', если даннах нет
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
	}
?>
</div>