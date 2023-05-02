let headerContent = `
<div class="header__menu">
<div class="menu">
	<div class="burger-menu">
		<a href="#" class="burger-menu__btn">
			<span class="burger-menu__lines"></span>
		</a>
		<nav class="burger-menu__nav">
			<a class="burger-menu__link" href="../layout/about.html">О нас</a>
			<a class="burger-menu__link" href="../layout/listProperNames.html">Список имен собственных</a>
			<a class="burger-menu__link" href="../layout/extendedSearch.html">Расширенный поиск</a>
			<a class="burger-menu__link" href="../layout/addNewPropername.html">Добавить новое имя собственное</a>
			<a class="burger-menu__link" href="../layout/auths.html">Авторизоваться</a>
			<a class="burger-menu__link" href="../layout/registr.html">Зарегистрироваться</a>
		</nav>
		<div class="burger-menu__overlay"></div>
	</div>
	<div class="menu__navbar">
		<nav class="menu__nav">
			<a class="menu__link" href="../layout/about.html">О нас</a>
			<a class="menu__link" href="../layout/listProperNames.html">Список имен собственных</a>
			<a class="menu__link" href="../layout/extendedSearch.html">Расширенный поиск</a>
			<a class="menu__link" href="../layout/addNewPropername.html">Добавить новое имя собственное</a>
		</nav>
	</div>
</div>
<div class="header__auths">
	<div class="login__auth menu__link">
		<a class="login__btn" href="">Авторизоваться</a>
	</div>
</div>
</div>
<div class="sub-header">
<div class="sub-header__image">
	<a href="../index.html"><img class="img-main-icon" src="../logoIcon.png" alt=""></a>
</div>
<div class="sub-header__title">
	<h1>
		Словарь имен собственных русского языка
	</h1>
</div>
<div class="search-field">
	<div class="search-field-__input">
		<input class="search-field__input" type="text" maxlength="44">
	</div>
	<div class="search-field__btn">
		<image src="../searchButtonIcon.png" class="btn-search"></image>
	</div>
</div>
</div>
`;

const renderHeader = () => {
	let header = document.querySelector('header');
	header.innerHTML = headerContent;
}

renderHeader();