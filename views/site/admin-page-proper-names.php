<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Имена собственные';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-admin-page-proper-names">
<h1>Имена собственные</h1>
	<input type="button" class="btn" data-btn="remove" value="✖">
	<input type="button" class="btn" data-btn="newElem" value="✚">
	<table class="table">
		<thead>
		<tr data-headers >
			<th scope="col"><input data-select-all type="checkbox"></th>
			<th scope="col">#</th>
			<th scope="col" data-edit-col="name" data-edit-type="input">Наименование</th>
			<th scope="col" data-edit-col="description" data-edit-type="input">Описание</th>
			<th scope="col" data-edit-col="aproved" data-edit-type="input">Статус</th>
			<th scope="col" data-edit-col="user_id" data-edit-type="input">Добавивший Пользователь</th>
			<th scope="col" data-edit-col="category_id" data-edit-type="input">Категория</th>
			<th scope="col">Редактировать</th>
		</tr>
		</thead>
		<tbody data-table-body>
		<?php foreach($properNames as $value){
			echo "<tr>
					<td><input type='checkbox' data-checkbox value=".$value['id']."></td>
					<td>".$value['id']."</td>
					<td>".$value['name']."</td>
					<td>".$value['description']."</td>
					<td>".($value['aproved']?'Одобренно':'Не одобрено')."</td>
					<td>".$value['user_id']."</td>
					<td>".$value['category_id']."</td>
					<td><input type='button' class='btn' data-btn='edit' value='✎'></td>
			</tr>";
		}
		?>
		</tbody>
	</table>
	<?= \yii\widgets\LinkPager::widget(['pagination' => $pages,
	'options' => [
		'class' => 'pagination pagination-circle pg-blue mb-0'],
		'linkOptions' => ['class' => 'page-link'],
	])?>
<template id="addElement">
	<tr>
		<td></td>
		<td></td>
		<td>
			<input class="form-control" name="name" type="text">
		</td>
		<td>
			<input class="form-control" name="description" type="text"></input>
		</td>
		<td>
		<select class="form-select" name="aproved">
			<option value="1">Одобрить</option>
			<option value="2">Не одобрить</option>
		</select>
		</td>
		<td>
			<input class="form-control" name="user_id" type="text" disabled="true" value=<?php echo Yii::$app->user->identity->id?>></input>
		</td>
		<td>
			<input  class="form-control"name="category_id" type="text"></input>
		</td>
		<td>
				<input type="button" class="btn" data-btn="add" value="✔">
				<input type="button" class="btn" data-btn="decline" value="✖">
		</td>
	</tr>
</template>
</div>
