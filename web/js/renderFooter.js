let footerContent = `<div class="footer__container container footer">
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
`;

const renderFooter = () => {
	let footer = document.querySelector('footer');
	footer.innerHTML = footerContent;
}

renderFooter();

// export { footerContent, renderFooter };