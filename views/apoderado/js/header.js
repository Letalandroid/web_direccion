let active = false;

const closed_menu = () => {

	const container_nav = document.querySelector('.container__nav');

	if (active) {
		container_nav.style.left = '-225px';
		container_nav.addEventListener('transitionend', onTransitionEnd);
		active = false;

	} else {
		container_nav.style.display = 'flex';
		container_nav.style.left = 0;
		active = true;
	}
};

const onTransitionEnd = () => {
	const container_nav = document.querySelector('.container__nav');
	container_nav.style.display = 'none';
	container_nav.removeEventListener('transitionend', onTransitionEnd);
};