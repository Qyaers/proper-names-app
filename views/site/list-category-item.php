<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

echo Html::a(Html::encode($model->name), ['/site/category-info'], [
	'data' => [
	'method' => 'get',
	'params' => [
		'id' => $model->id,
		'name' => $model->name,
		'prevTitle' => $this->title,
		'prevId' => Yii::$app->request->get('id')
	],
]
]);
