<?php
use yii\widgets\ListView;
use yii\helpers\Html;
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-category-list"></div>
	<div class="proper-name">
		<h1 class="proper-name__title"><?= Html::encode($this->title) ?></h1>
		<p class="proper-name__discription">
			<?= Html::encode(is_object($propNames)?$propNames->description:$propNames)?>
		</p>
	</div>
</div>