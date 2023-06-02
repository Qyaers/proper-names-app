<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\base\Model;

$this->title = 'Выгрузить информацию';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-data-download">
	<h1><?= Html::encode($this->title) ?></h1>
		<div class="d-inline-flex">
			<div class="row ms-5">
				<div class="">
					<?php $form = ActiveForm::begin(['id' => 'form-data-download']); ?>
						<?= $form->field($model, 'category_id')->dropDownList(
							\yii\helpers\ArrayHelper::map(\app\models\Category::find()->andWhere(['in','id',\app\models\ProperName::find()->select(['category_id'])->distinct()])->all(), 'id', 'name')
						)->label('Категория');
						ActiveForm::end();?>
						
						<div class="download-file">
							<button class ='btn download-file-btn' name ='add-button'>Выгрузить информацию по категории</button>
						</div>
					<?php
					if($message){
						echo '<h2>Данны список имен собственных был выгружен.</h2>';
						foreach ($message as &$value) {
							echo '<p class="js-download">'.Html::encode($value['name']).'</p>';
						}
					}?>
				</div>
			</div>
		</div>
</div>
