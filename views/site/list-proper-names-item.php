<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

echo Html::a(Html::encode($model->name), ['/site/proper-name'], [
	'data' => [
	'method' => 'get',
	'params' => [
		'name' => $model->name,
	],
]
]);
