<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\base\Model;

$this->title = 'Добавить новые имена собственные';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-new-proper-name">
	<h1><?= Html::encode($this->title) ?></h1>
		<div class="d-inline-flex">
			<div class="">
					<div class="file-selector">
					</div>
					<input type="file" name="" class="btn file-selector-input" title=" " id="" accept=".txt">
					<ul class="output"></ul>
					<button class="add-from-file__btn btn"type="submit">Добавить из файла</button>
			</div>
			<div class="row ms-5">
				<div class="">
					<?php $form = ActiveForm::begin(['id' => 'form-proper-name']); ?>
						<?= $form->field($model, 'name')->textInput()->label('Наименование') ?>
						<?= $form->field($model, 'description')->textarea(['rows' => '6'])->label('Описание') ?>
						<?= $form->field($model, 'category_id')->dropDownList(
							\yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name')
						)->label('Категория') ?>
						<?= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->id])->label(false); ?>
						<?= $form->field($model, 'type')->hiddenInput(['value'=> 'form' ])->label(false); ?>
						<div class="form-group">
							<?= Html::submitButton('Добавить из формы', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
						</div>
					<?php ActiveForm::end(); ?>
					<?= Html::encode($message) ?>
				</div>
			</div>
		</div>
</div>
