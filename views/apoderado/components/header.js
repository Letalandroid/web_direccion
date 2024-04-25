const header = () => {
    const headerContent = `
			<button onclick="closed_menu()"><i class="fas fa-bars"></i></button>
			<div class="logo__container">
				<a href="/apoderado">
					<img src="/views/apoderado/assets/img/logo.jpg" alt="logo_clavelitos_de_sjt" />
				</a>
			</div>`;

    const headerElement = document.createElement('header');
	headerElement.innerHTML = headerContent;

	document.body.insertBefore(headerElement, document.body.firstChild);
}

header();
