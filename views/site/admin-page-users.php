<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-admin-page-users">
<h1>Пользователи</h1>
	<input type="button" class="btn" data-btn="remove" value="✖">
	<input type="button" class="btn" data-btn="newElem" value="✚">
	<table class="table">
		<thead>
		<tr data-headers >
			<th scope="col"><input data-select-all type="checkbox"></th>
			<th scope="col">#</th>
			<th scope="col" data-edit-col="login" data-edit-type="input">Логин</th>
			<th scope="col" data-edit-col="password" data-edit-type="input">Пароль</th>
			<th scope="col" data-edit-col="email" data-edit-type="input">Почта</th>
			<th scope="col" data-edit-col="role" data-edit-type="input">Токен доступа</th>
			<th scope="col" data-edit-col="acessToken" data-edit-type="input">Токен доступа</th>
			<th scope="col" data-edit-col="authKey" data-edit-type="input">Код аутентификации</th>
			<th scope="col">Редактировать</th>
		</tr>
		</thead>
		<tbody data-table-body>
		<?php foreach($users as $value){
			echo "<tr>
					<td><input type='checkbox' data-checkbox value=".$value['id']."></td>
					<td>".$value['id']."</td>
					<td>".$value['login']."</td>
					<td>".$value['password']."</td>
					<td>".$value['email']."</td>
					<td>".$value['role']."</td>
					<td>".$value['acessToken']."</td>
					<td>".$value['authKey']."</td>
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
			<input class="form-control" name="password" type="text"></input>
		</td>
		<td>
			<input class="form-control" name="email" type="text"></input>
		</td>
		<td>
			<input class="form-control" name="role" type="text"></input>
		</td>
		<td>
			<input  class="form-control"name="acessToken" type="text"></input>
		</td>
		<td>
			<input class="form-control" name="authKey" type="text">
		</td>
		<td>
				<input type="button" class="btn" data-btn="add" value="✔">
				<input type="button" class="btn" data-btn="decline" value="✖">
		</td>
	</tr>
</template>
</div>
