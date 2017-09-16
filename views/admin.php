<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
<div id="light" class="white_content">
	<div>
		<br>
		<h1>Estado del Sistema
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><img src="./images/close.png" alt="Cerrar" title="Cerrar"></a>
		</h1>
		<br>
		<table>
			<tr>
				<td>
				<img src="./images/panel/gear-icon.png" alt="Panel de Control">
				</td>
				<td>
					<?php
						/*Nombre Aplicacion*/
						echo '<span>● Aplicación:</span> ClickPropiedades.com <br>';
						
						/*Versión Aplicacion*/
						echo '<span>● Versión Aplicación:</span> 1.0.0 <br>';

						/*Funcion Ping*/
						function ping($host)
						{
								exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
								return $rval === 0;
						}

						/*Chequeo Status del Host*/
						$host = 'www.clickpropiedades.com';
						$up = ping($host);

						/*Informo estado del servidor*/
						echo '<span>● Estado Servidor:</span> <img src="./images/panel/'.($up ? 'up-icon' : 'down-icon').'.png" alt="'.($up ? 'up' : 'down').'" /><br>';

						/*IP Servidor*/
						$localIP = getHostByName(getHostName());
						echo '<span>● IP Servidor:</span> '.$localIP.'<br>';
						
						/*Sistema Operativo*/
						echo '<span>● SO Servidor:</span> '.PHP_OS.'<br>';
						
						/*Fecha y Hora*/
						date_default_timezone_set('America/Argentina/Buenos_Aires');
						echo '<span>● Fecha y Hora:</span> '.date("d/m/Y H:m").'<br>';
						
						/*Version PHP*/
						echo '<span>● Versión PHP:</span> ' . phpversion().'<br>';
						
						/*Conexion a la base de datos*/
						$conn = mysql_connect('localhost', 'revistac_db', 'C0mpuca5as');
						$db   = mysql_select_db('revistac_db');
						
						/*Informo estado del servidor MySQL*/
						echo '<span>● Estado MySQL:</span> <img src="./images/panel/'.(@mysql_ping() ? 'up-icon' : 'down-icon').'.png" alt="'.(@mysql_ping() ? 'up' : 'down').'" /><br>';
						
						/*Version MySQL*/
						if ($conn) {
							printf("<span>● Versión MySQL:</span> %s\n", mysql_get_server_info());
							echo '<br>';
						}
					?>
				</td>
			</tr>
		</table>
	</div>
</div>
<div id="fade" class="black_overlay"></div>
<table class="content">
	<tr>
		<td class="content left">
		<?php
		include 'includes/menu_admin.php';
		?>
		</td>
		<td class="content central">
		<div class="cheader"><img src="./images/panel/panel.jpg" alt="Panel de Administración"></div>
		<table class="cpanel">
			<tr>
				<td><a href="./locations.php"><img src="./images/panel/location-icon.png" alt="Lugares"></a><br>Lugares</td>
				<td><a href="./agency.php"><img src="./images/panel/access-icon.png" alt="Accesos"></a><br>Accesos</td>
				<td><a href="./featured.php"><img src="./images/panel/featured-icon.png" alt="Destacados"></a><br>Destacados</td>
				<td><a href="./login.php"><img src="./images/panel/task-icon.png" alt="Tareas"></a><br>Tareas</td>
			</tr>
			<tr>
				<td><a href="./report.php"><img src="./images/panel/statistics-icon.png" alt="Estadisticas"></a><br>Estadisticas</td>
				<td><a href="./plans.php"><img src="./images/panel/plans-icon.png" alt="Planes"></a><br>Planes</td>
				<td><a href="#" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><img src="./images/panel/status-icon.png" alt="Sistema"></a><br>Sistema</td>
				<td><a href="./logout.php"><img src="./images/panel/logout-icon.png" alt="Salir"></a><br>Salir</td>
			</tr>
		</table>
        </td>
		<td class="content right">	
		</td>
	</tr>
</table>
<?php
include 'includes/footer.php';
?>