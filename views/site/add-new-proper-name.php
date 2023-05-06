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
				<div class="file-selector"></div>
				<input type="file" name="" class="file-selector-input" id="" accept=".txt, .xlsx, .csv">
				<ul class="output"></ul>
	</p>
</div>
