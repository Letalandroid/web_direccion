<?php

const PAGE_LIST = array('Agenda', 'Cursos', 'Conducta', 'Docentes');

function show_nav($page_name)
{
	echo '<div class="container__nav"><nav><ul>';

	foreach (PAGE_LIST as $page) {
		$class = ($page === $page_name) ? 'class="selected__page"' : '';

		echo "<li $class>
            <i class=\"fas fa-chevron-right\"></i>
            <a class=\"link__menu\" href=\"/director/" . strtolower($page) . "\">" . $page . "</a>
        </li>";
	}

	echo '</ul></nav>
			<a href="/controllers/utils/closedSession.php?closed=true" id="closedSession">
				<i class="fas fa-door-open"></i>
				Cerrar sesión
			</a></div>';
}