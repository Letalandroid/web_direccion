<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="/css/header.css" />
		<link rel="stylesheet" href="/css/agenda.css" />
		<script defer src="/components/header.js"></script>
		<script defer src="/components/nav.js"></script>
		<link
			rel="shortcut icon"
			href="/assets/img/logo_transparent.png"
			type="image/x-icon" />
		<script defer src="/js/header.js"></script>
        <script defer src="/js/agenda.js"></script>
		<script defer>
			document.addEventListener("DOMContentLoaded", () => {
				nav('Agenda');
				closed_menu();
			});
		</script>
		<script
			src="https://kit.fontawesome.com/8b1c082df7.js"
			crossorigin="anonymous"></script>
		<title>I.E.P Los Clavelitos de SJT - Piura | Agenda</title>
	</head>
	<body>
		<main>
            <div class="container__section">
                <h2>Próximos Eventos</h2>
                <table>
                    <tr>
                        <th colspan="7">Agenda</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="border: 1px solid var(--green);">2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>9</td>
                        <td>10</td>
                        <td>11</td>
                        <td>12</td>
                        <td>13</td>
                        <td>14</td>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td>16</td>
                        <td>17</td>
                        <td class="event">18</td>
                        <td>19</td>
                        <td>20</td>
                        <td>21</td>
                    </tr>
                    <tr>
                        <td>22</td>
                        <td>23</td>
                        <td>24</td>
                        <td>25</td>
                        <td>26</td>
                        <td>27</td>
                        <td>28</td>
                    </tr>
                    <tr>
                        <td>29</td>
                        <td class="event">30</td>
                        <td>31</td>
                    </tr>
                </table>
                <div id="container_event">
                </div>
            </div>
		</main>
	</body>
</html>