<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/icon.png')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
	<header id="header" class="header">
		<?php
		NavBar::begin([
			'options' => ['class' => 'navbar-expand-md fixed-top menu-nav']
		]);
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav menu-nav'],
			'items' => [
					['label' => 'Home', 'url' => ['/site/index']],
					['label' => 'About', 'url' => ['/site/about']],
					['label' => 'Contact', 'url' => ['/site/contact']],
					Yii::$app->user->isGuest
						? ['label' => 'Login', 'url' => ['/site/login']]
						: '<a class="nav-item">'
							. Html::beginForm(['/site/logout'])
							. Html::submitButton(
								'Logout (' . Yii::$app->user->identity->username . ')',
								['class' => 'nav-link btn btn-link logout']
							)
							. Html::endForm()
						. '</a>'
			]
		]);
		NavBar::end();
		?>
	</header>
	<div class="wrapper">
		<main class="main">
			<div class="container">
				<?php if (!empty($this->params['breadcrumbs'])): ?>
						<?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
				<?php endif ?>
				<?= Alert::widget() ?>
				<?= $content ?>
		</main>
	</div>

	<footer id="footer" class="footer">
		<div class="container footer">
			<div class="">&copy; My Company <?= date('Y') ?></div>
			<div class=""><?= Yii::powered() ?></div>
		</div>
	</footer>
</div>
			</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
