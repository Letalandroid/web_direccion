<?php

const PAGE_LIST = array('Agenda', 'Asistencias', 'Notas', 'Conducta');

function show_nav($page_name)
{
	echo '<div class="container__nav"><nav><ul>';

	foreach (PAGE_LIST as $page) {
		$class = ($page === $page_name) ? ' class="selected__page"' : '';

		echo "<li{$class}>
            <i class=\"fas fa-chevron-right\"></i>
            <a class=\"link__menu\" href=\"/docente/" . strtolower($page) . "\">" . $page . "</a>
        </li>";
	}

	echo '</ul></nav>
			<button id="closedSession">
				<i class="fas fa-door-open"></i>
				Cerrar sesión
			</button></div>';
}