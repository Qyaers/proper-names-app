<?php
use yii\widgets\ListView;
use yii\helpers\Html;
$this->title = $title;

?>
<div class="site-category-list"></div>
	<div class="proper-name">
		<h1 class="proper-name__title"><?= Html::encode($this->title) ?></h1>
		<p class="proper-name__discription">
			<?php 
			if($propNames){
				echo Html::encode(is_object($propNames)?$propNames->description:$propNames);
			}
			else{
				echo "<p> Произошла ошибка, данного имени собственного не существует</p>";
			}?>
		</p>
	</div>
</div>