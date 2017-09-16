<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
<table class="content">
	<tr>
		<td class="content left">
		<?php
		include 'includes/menu_user.php';
		?>
		<br>
		<br>
		</td>
		<td class="content central">
		<div class="griduser">
		<?php
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		
		function getRealUserIp(){
			switch(true){
			  case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
			  case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
			  case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
			  default : return $_SERVER['REMOTE_ADDR'];
			}
		};
		
		$ip = getRealUserIp();

		$r = $vars['salidaInfoRol'];
			while($user = $r->fetch()){
				echo "<span>¡Bienvenido ".$user['razonSocial']." a Click Propiedades!</span>";
				if (empty($user['logo'])) {
					echo "<img src='./images/nodisponible_inmo.jpg' alt='Sin Imagen'>";
				}
				else {
					echo "<img src='./uploads/".$user['idInmobiliaria']."/".$user['logo']."' alt='Inmobiliaria'>";
				}
				echo "<br>";
				echo "● Usuario: ".$user['usuario']." <br>";
				echo "● Rol: ".$user['rol']." <br>";
				echo "● IP: ".$ip." <br>";
				echo "● Fecha: ".date("d/m/Y")." ".date("h:i:sa")." <br>";
			};
		?>
		</div>
		<br>
		<table class="gridview">
				<?php
					$c = $vars['salidaCentral'];
					while($central = $c->fetch())
					{
						echo "<tr>";
						echo "<td>";
						echo "<div class='wrapper'>";
						if ($central['destacado'] == 1 && $central['reservado'] == 1) {
							echo "<div class='ribbon-wrapper-orange'><div class='ribbon-orange'>Reservado</div></div>";
						}
						if ($central['destacado'] == 1 && $central['reservado'] == 0) {
							echo "<div class='ribbon-wrapper-green'><div class='ribbon-green'>Destacado</div></div>";
						}
						if ($central['destacado'] == 0 && $central['reservado'] == 1) {
							echo "<div class='ribbon-wrapper-orange'><div class='ribbon-orange'>Reservado</div></div>";
						}
						if (empty($central['fotoInmueble'])) {
							echo '<div class="gridimg"><img src="./images/nodisponible.jpg" alt="Sin Imagen"></div>';
						}
						else {
							echo "<div class='gridimg'><img src='./uploads/".$central['idInmobiliaria']."/".$central['idAviso']."/".$central['fotoInmueble']."' alt='".$central['inmueble']."'></div>";
						}
						echo "<div class='gridmid'>";
												echo "<a href='DetailController.php?destino=".$central['idAviso']."'>";
						echo "<h1>".$central['inmueble']." en ".$central['localidad']." / ".$central['provincia']."</h1>";
						echo "</a>";
						echo "● Dirección: ".$central['calleAviso']." ".$central['alturaAviso']." ".$central['pisoAviso']."<br>";
						echo "● Tipo de Operacion: ".$central['operacion']."<br>";
						echo "● Precio: ".$central['moneda']." ".$central['precio']."<br>";
						echo "● Comercializado por: ".$central['NombreInmobiliaria']."<br>";
						echo "<br>";
						if (empty($central['descripcion'])) {
							echo "● Descripción: <br> Aviso sin descripción. <br>";
						}
						else {
							echo "● Descripción: <br>".substr($central['descripcion'],0,140)."... <br>";
						}
						echo "<br>";
						echo "</div>";
						echo "<div class='gridedit'>";
				?>
						<a href="editAd.php?destino=<?php echo $central['idAviso']; ?>" onclick="return confirm('¿Desea editar el aviso?');"><img src="./images/edit_ad.png" alt="Editar" title="Editar"></a>
						<a href="soldAd.php?destino=<?php echo $central['idAviso']; ?>" onclick="return confirm('¿Desea cambiar el estado del aviso a Reservado?');"><img src="./images/sold_ad.png" alt="Reservar" title="Reservar"></a>
						<a href="deleteAd.php?destino=<?php echo $central['idAviso']; ?>&pertenece=<?php echo $central['idInmobiliaria']; ?>" onclick="return confirm('¿Desea eliminar el aviso?');"><img src="./images/del_ad.png" alt="Borrar" title="Borrar"></a>
				<?php
						echo "</div>";
						echo "</div>";
						echo "</td>";
						echo "</tr>";
					};
				?>
		</table>
		<br>
		<div class="pagination">
		<?php
			$d = $vars['salidaTotalRegistros'];
			while($total = $d->fetch()) {
				$total_records = $total['totalRegistros'];
				$total_pages = ceil($total_records / 20);
					  
				for ($i=1; $i<=$total_pages; $i++) { 
					echo "<span><a href='user.php?page=".$i."'>".$i."</a></span> "; 
				};
		};
		?>
		</div>
        </td>
		<td class="content right">	
		</td>
	</tr>
</table>
<?php
include 'includes/footer.php';
?>