const setActiveLink = () => {
	let links = document.querySelectorAll('.menu__link');
	let activeLink = document.title;
	for (let i = 0; i < links.length; i++) {
		if (links[i].innerText == activeLink) {
			links[i].classList.add('menu_link__active');
			break
		}
		else {
			links[i].classList.remove('menu_link__active');
		}
	}
}
const burgerMenu = () => {
	const button = document.querySelector('.burger-menu__btn', '.burge-menu_lines');
	const link = document.querySelectorAll('.burger-menu__link');

	button.addEventListener('click', (e) => {
		e.preventDefault();
		toggleMenu();
	});

	for (let i = 0; i < link.length; i++) {
		link[i].addEventListener('click', toggleMenu);
	}

}
const toggleMenu = () => {
	menu = document.querySelector('.burger-menu')
	button = document.querySelector('.burger-menu__btn')
	menu.classList.toggle('burger-menu__active');
	button.classList.toggle('burger-menu__btn-active');
	if (menu.className.includes("burger-menu__active")) {
		document.body.style.overlow = 'hidden';
	}
	else {
		document.body.style.overlow = 'visible';
	}
}

setActiveLink();
burgerMenu();


