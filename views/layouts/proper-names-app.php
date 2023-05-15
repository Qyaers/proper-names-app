<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Menu;
use yii\bootstrap\Modal;

AppAsset::register($this);

$this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->request->csrfParam]);
$this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->request->getCsrfToken()]);
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
		<div class="header__menu">

			<div class="menu">
			<div class="header__image">
				<a href="/"><img class="img-main-icon" src="../logoIcon.png" alt=""></a>
			</div>
				<div class="burger-menu">
					<a href="" class="burger-menu__btn">
						<span class="burger-menu__lines"></span>
					</a>
					<nav class="burger-menu__nav">
					<div class="header__image">
				<a href="/"><img class="img-main-icon-burger" src="../logoIcon.png" alt=""></a>
			</div>
						<?php
							echo Menu::widget([
								'options' => ['class' => ''],
								'items' => [
									['label' => 'О нас', 'url' => ['about']],
									['label' => 'Список имен собственных', 'url' => ['list-proper-names']],
									['label' => 'Расширенный поиск', 'url' => ['extended-search']],
									Yii::$app->user->isGuest? [] :		
									['label' => 'Добавить новую информацию', 'url' => ['add-new-proper-name']],
									],
									'itemOptions'=>['class'=>'burger-menu__link']
								]);
						?>
					</nav>
					<div class="burger-menu__overlay"></div>
				</div>
				<div class="menu__navbar">
					<nav class="menu__nav">
						<?php
							echo Menu::widget([
								'options' => ['class' => 'navbar-nav'],
								'items' => [
									['label' => 'О нас', 'url' => ['about']],
									['label' => 'Список имен собственных', 'url' => ['list-proper-names']],
									['label' => 'Расширенный поиск', 'url' => ['extended-search']],
									Yii::$app->user->isGuest? [] :		
									['label' => 'Добавить новую информацию', 'url' => ['add-new-proper-name']],
									],
									'itemOptions'=>['class'=>'menu__link']
								]);
						?>
					</nav>
				</div>

			</div>
			
			<div class="header__auths">
				<div class="login__auth">
					<?php
						echo Nav::widget([
							'options' => ['class' => 'login-auth__btn navbar-nav'],
									'items' =>[
							Yii::$app->user->isGuest? ['label' =>  " Авторизоваться", 'url' => ['login']] 
							:
							'<a class="">'
							. Html::beginForm(['logout'])
							. Html::submitButton(
								Yii::$app->user->identity->login .'(Logout)',
								['class' => 'nav-link btn-link logout ']
							)
							. Html::endForm()
							.'</a>'
						]])?>
				</div>
			</div>
		</div>
		<div class="sub-header">
		<div class="search-field">
				<div class="search-field-__input">
					<input class="search-field__input" type="text" maxlength="44">
				</div>
				<div class="search-field__btn">
					<image src="../searchButtonIcon.png" class="btn-search"></image>
				</div>
		</div>
		</div>
	</header>

	<main class="main">
		<div class="container content">
			<?php if (!empty($this->params['breadcrumbs'])): ?>
					<?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
			<?php endif ?>
			<?= Alert::widget() ?>
			<?= $content ?>
		</div>
	</main>

	<footer id="footer" class="footer">
		<div class="footer__container container footer">
		<div class="copyright">
				&copy; 2023 www.proper-names-app - All Rights Reserved.
		</div>
		<div class="socialmedia">
			<p class="socialmedia__title">
				Наши соцсети:
			</p>
			<img class="socialmedia__vk-icon" src="../Telegram_logo.png" alt="">
			<img class="socialmedia__tg-icon" src="../vkIcon.png" alt="">
		</div>
		</div>
	</footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
