<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-personal-account">
	<h1><?= Html::encode($this->title) ?></h1>
	<div>
		<div class="personal-account-info">

			<?php $form = ActiveForm::begin([
				'id' => 'personal-account-form',
				'layout' => 'horizontal',
				'fieldConfig' => [
					'template' => "{label}\n{input}\n{error}",
					'labelOptions' => ['class' => 'col-lg-1 '],
					'inputOptions' => ['class' => 'col-lg-3 '],
					'errorOptions' => ['class' => 'col-lg-3 invalid-feedback'],
				],
			]); ?>

				<?= $form->field($model, 'login')->textInput(['placeholder' => Yii::$app->user->identity->login, 'value'=>Yii::$app->user->identity->login])->label('Логин') ?>

				<?= $form->field($model, 'password')->passwordInput(['placeholder' => '*******', 'value'=>Yii::$app->user->identity->password])->label('Пароль')  ?>

				<?= $form->field($model, 'email')->textInput(['placeholder' => Yii::$app->user->identity->email, 'value'=>Yii::$app->user->identity->email])->label('Email') ?>
				<?= $form->field($model, 'userId')->hiddenInput(['value'=> Yii::$app->user->id])->label(false); ?>
					<div class="auths-btns">
						<?= Html::submitButton('Изменить', ['class' => 'btn', 'name' => 'login-button']) ?> 
					</div>
				</div>
		</div>
		<?php ActiveForm::end();
		
		if(!empty($properNames)){
			echo "<div class='user-uploads-info'>
			<table class='table'>
				<thead>
				<tr data-headers >
					<th scope='col'><input data-select-all type='checkbox'></th>
					<th scope='col'>#</th>
					<th scope='col' data-edit-col='name' data-edit-type='input'>Наименование</th>
					<th scope='col' data-edit-col='description' data-edit-type='textarea'>Описание</th>
					<th scope='col'>Изменить</th>
				</tr>
				</thead>
				<tbody data-table-body>";
				$i=1;
				foreach($properNames as $value){
					echo "<tr>
							<td><input type='checkbox' data-checkbox value=".$value["id"]."></td>
							<td>".$i++."</td>
							<td>". $value['name']."</td>
							<td>".$value['description']."</td>
							<td><input class='btn' type='button' data-btn='edit' value='✎'></td>
					</tr>";
				}
				echo "
				</tbody>
			</table>
			</div>
		<input class='btn' type='button' data-btn='remove' value='Удалить выбранные'>";
		}?>
	</div>
</div>
<template id="addElement">
	<tr>
		<td></td>
		<td><input name="name" type="text"></td>
		<td>
			<textarea name="description" cols="30" rows="10"></textarea>
		</td>
		<td>
				<input class='btn' type="button" data-btn="add" value="✔">
				<input class='btn' type="button" data-btn="decline" value="✖">
		</td>
	</tr>
</template>
