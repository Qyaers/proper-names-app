<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Добавить новую информацию';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-new-proper-name">
	<h1><?= Html::encode($this->title) ?></h1>
	<p>
	<code><?= __FILE__ ?></code>
				<div class="file-selector">
				</div>
				<input type="file" name="" class="btn file-selector-input " title=" " id="" accept=".txt, .xlsx, .csv">
				<ul class="output"></ul>
				<button class="btn"type="submit">Добавить из файла</button>
	</p>
</div>
