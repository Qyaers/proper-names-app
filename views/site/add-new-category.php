<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\base\Model;

$this->title = 'Добавить новую категорию';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-new-proper-name">
	<h1><?= Html::encode($this->title) ?></h1>
		<div class="d-inline-flex">
			<div class="">
					<div class="file-selector">
					</div>
					<input type="file" name="" class="btn file-selector-input " title=" " id="" accept=".txt">
					<ul class="output"></ul>
					<button class="add-from-file__btn btn"type="submit">Добавить из файла</button>
			</div>
			<div class="row ms-5">
				<div class="">
					<?php $form = ActiveForm::begin(['id' => 'form-category']); ?>
						<?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('Наименование') ?>
						<?= $form->field($model, 'ancestor')->dropDownList(
							\yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name')
						)->label('Предок') ?>
						<div class="form-group">
							<?= Html::submitButton('Добавить из формы', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
						</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
</div>
