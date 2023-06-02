<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Категории';

?>
<div class="site-admin-page-category">
<h1>Категории</h1>
	<input type="button" class="btn" data-btn="remove" value="✖">
	<input type="button" class="btn" data-btn="newElem" value="✚">
	<table class="table">
		<thead>
		<tr data-headers >
			<th scope="col"><input data-select-all type="checkbox"></th>
			<th scope="col">#</th>
			<th scope="col" data-edit-col="name" data-edit-type="input">Категория</th>
			<th scope="col" data-edit-col="ancestor" data-edit-type="input">Предок</th>
			<th scope="col">Редактировать</th>
		</tr>
		</thead>
		<tbody data-table-body>
		<?php foreach($categories as $value){
			echo "<tr>
					<td><input type='checkbox' data-checkbox value=".$value['id']."></td>
					<td>".$value['id']."</td>
					<td>".$value['name']."</td>
					<td>".$value['ancestor']."</td>
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
		<td><input name="name" type="text"></td>
		<td>
			<input name="ancestor" type="text"></input>
		</td>
		<td>
				<input type="button" class="btn" data-btn="add" value="✔">
				<input type="button" class="btn" data-btn="decline" value="✖">
		</td>
	</tr>
</template>
</div>
