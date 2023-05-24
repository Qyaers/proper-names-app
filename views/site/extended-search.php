<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Расширенный поиск';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-extended-search">
	<h1><?= Html::encode($this->title) ?></h1>

		<?php $form = ActiveForm::begin([
		'id' => 'extended-form',
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n{input}\n{error}",
			'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
			'inputOptions' => ['class' => 'col-lg-3 form-control'],
			'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
		],
		]); ?>

		<?= $form->field($model, 'category')->dropDownList(
			\yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name'))->label('Категория') ?>

		<?= $form->field($model, 'propName')->textInput(['autofocus' => true])->label('Имя собственное')  ?>

		<?= $form->field($model, 'categorySearch')->checkbox(['uncheck' => false,
			'template' => "<div class=\"col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
		])->label('Поиск по категории') ?>
		<?= $form->field($model, 'properNameSearch')->checkbox(['uncheck' => false,
			'template' => "<div class=\"col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
		])->label('Поиск по имени собственному')?>
		
		<div class="auths-btns">
			<?= Html::submitButton('Найти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?> 
		</div>
	<?php ActiveForm::end(); ?>
		
		<p class="error-text"><?= Html::encode($message)?></p>
</div>


	<code><?= __FILE__ ?></code>
</div>
