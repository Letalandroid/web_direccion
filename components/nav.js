const pages_list = ['Asistencias', 'Agenda', 'Notas', 'Conducta']

const nav = (pageName) => {
	let navContent = `<nav><ul>`;

		pages_list.forEach(page => {
			navContent += `
					<li class='${page === pageName ? 'selected__page' : ''}'>
						<i class="fas fa-chevron-right"></i>
						<a class="link__menu" href="/${page.toLowerCase()}">${page}</a>
					</li>`;
		});

		navContent += `</ul></nav>
					<button id="closedSession">
						<i class="fas fa-door-open"></i>
						Cerrar sesión
					</button>`;

	const navElement = document.createElement('div');
	navElement.className = 'container__nav';
	navElement.innerHTML = navContent;

    const mainElement = document.querySelector('main');

	mainElement.insertBefore(navElement, mainElement.firstChild);
	document.title += ` | ${pageName}`;
};