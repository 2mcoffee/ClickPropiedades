<?php
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ){
	if (isset($_POST['name']) AND isset($_POST['email']) AND isset($_POST['telefono']) AND isset($_POST['subject']) AND isset($_POST['message']) AND isset($_POST['emailInmo']) AND isset($_POST['codigo']) AND isset($_POST['url'])) {
		$to = $_POST["emailInmo"];
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$emailInmo = filter_var($_POST['emailInmo'], FILTER_SANITIZE_EMAIL);
		$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
		$message .= "Nombre y Apellido: ".filter_var($_POST['name'], FILTER_SANITIZE_STRING)."\n\n";
		$message .= "Email: ".filter_var($_POST['email'], FILTER_SANITIZE_STRING)."\n\n";
		$message .= "Telefono: ".filter_var($_POST['telefono'], FILTER_SANITIZE_STRING)."\n\n";
		$message .= "Mensaje: ".filter_var($_POST['message'], FILTER_SANITIZE_STRING)."\n\n";
		$message .= "URL del Aviso: ".filter_var($_POST['url'], FILTER_SANITIZE_STRING)."\n\n";
		$message .= "Codigo de Ficha: ".filter_var($_POST['codigo'], FILTER_SANITIZE_STRING);
		$sent = email($to, $emailInmo, $name, $subject, $message);
		if ($sent) {
			echo 'Mensaje enviado.';
		} else {
			echo 'Mensaje no enviado.';
		}
	}
	else {
		echo 'Todos los campos son obligatorios.';
	}
	return;
}

function email($to, $from_mail, $from_name, $subject, $message){
	$header = array();
	$header[] = "MIME-Version: 1.0";
	$header[] = "From: no-reply@clickpropiedades.com\nReply-To:".$_POST["emailInmo"]."\n";
	/* Set message content type HTML*/
	$header[] = "Content-type:text/html; charset=iso-8859-1";
	$header[] = "Content-Transfer-Encoding: 7bit";
	if( mail($to, $subject, $message, implode("\r\n", $header)) ) return true; 
}
?>
<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
<?php 
$arreglo = $vars['detalle'];
	while($ar = $arreglo->fetch())
		{
?>
<!--Popup Oculto-->
<div id="light" class="white_content">
	<div>
		<br>
		<h1>Contactar Asesor
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><img src="./images/close.png" alt="Cerrar" title="Cerrar"></a>
		</h1>
		<br>
		<div class="alert"></div>
		<form id="form" action="" method="post">
		<div>
			<input placeholder="Nombre y Apellido" type="text" name="name" required id="name">
		</div>
		<div>
			<input placeholder="Email" type="email" name="email" required id="email">
		</div>
		<div>
			<input placeholder="Telefono" type="text" name="telefono" required id="telefono">
		</div>
		<div>
			<textarea placeholder="Ingrese aqui su consulta" name="message" required id="message"></textarea>
		</div>
		<div>
			<input type="hidden" name="subject" value="Contacto desde Click Propiedades" required id="subject">
		</div>
		<div>
			<input type="hidden" name="emailInmo" value="<?php echo $ar['MailInmobiliaria']; ?>" required id="emailInmo">
		</div>
		<div>
			<input type="hidden" name="codigo" value="<?php echo $ar['CodigoFicha']; ?>" required id="codigo">
		</div>
		<div>
			<input type="hidden" name="url" value="<?php echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" required id="url">
		</div>
		<br>
		<div>
			<input type="reset" value="Limpiar"> <button name="submit" type="submit" id="submit">Enviar</button>
		</div>
		</form>
	</div>
</div>
<div id="fade" class="black_overlay"></div>
<table class="content">
	<tr>
		<td class="content left">
			<?php
			include 'includes/minisearch.php';
			?>	
			<br>
		</td>
		<td class="content central">
			<div class="location">
				<table class="locationhead">
					<tr>
						<td>
						<?php echo "<h1>".utf8_encode($ar['Localidad'])."</h1>"; ?>
						<?php echo "<h2><img src='./images/location.png' alt='Ubicacion'> Provincia de ".$ar['Provincia']."</h2>"; ?>
						</td>
						<td>
						<?php
								if (empty($ar['Precio']) || $ar['Precio'] == 0 || $ar['Precio'] == 1) {
									echo '<h3>CONSULTAR</h3>';
								}
								else {
									echo "<h3>".$ar['Moneda']."".$ar['Precio']."</h3>";
								}
						?>
						<?php echo "<h4>".$ar['Operacion']."</h4>"; ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="locationBar">
			</div>
			<br>
			<div class="general">
				<h1>Detalles Generales:</h1>
				<div class="galeria">
	    			<div class="lSSlideOuter ">
	        			<div class="lSSlideWrapper usingCss on" style="transition-duration: 400ms;">
							<ul id="imageGallery">
								<?php 
								$imagen = $vars['fotos'];
								while($pic = $imagen->fetch()){
									if (empty($pic['url'])) {									
										echo '<li data-thumb="./images/nodisponible.jpg" data-src="./images/nodisponible.jpg">';
										echo '<img class="my-foto" src="./images/nodisponible.jpg"  data-large="./images/nodisponible.jpg" title="Propiedad" alt="Propiedad">';
										echo '</li>';
									}
									else {
										echo '<li data-thumb="./uploads/'.$ar['IdImobiliaria']."/".$ar['IdAviso']."/".$pic['url'].'" data-src="./uploads/'.$ar['IdImobiliaria']."/".$ar['IdAviso']."/".$pic['url'].'">';
										echo '<img class="my-foto" src="./uploads/'.$ar['IdImobiliaria']."/".$ar['IdAviso']."/".$pic['url'].'"  data-large="./uploads/'.$ar['IdImobiliaria']."/".$ar['IdAviso']."/".$pic['url'].'" title="Propiedad" alt="Propiedad">';
										echo '</li>';
									}
								}
								?>
			    			</ul>
			    		</div>
			    	</div>
			    </div>
		    	<div class="description">
				    <table>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Sup. Total (m2):</span> <?php echo $ar['sup_total']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Sup. Cubierta (m2):</span> <?php echo $ar['sup_cubierta']; ?></td>
						</tr>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Estado:</span> <?php echo $ar['EstadoInmueble']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Antigüedad:</span> <?php echo $ar['Antiguedad']; ?></td>
						</tr>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Luminosidad:</span> <?php echo $ar['luminosidad']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Terraza:</span> <?php echo $ar['terraza']; ?></td>
						</tr>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Piso:</span> <?php echo $ar['PisoAviso']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Apto Profesional:</span> <?php echo $ar['AptoProfesional']; ?></td>
						</tr>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Seguridad:</span> <?php echo $ar['seguridad']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Ambientes:</span> <?php echo $ar['Ambientes']; ?></td>
						</tr>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Dormitorios:</span> <?php echo $ar['Dormitorios']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Garage:</span> <?php echo $ar['garage']; ?></td>
						</tr>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Baños:</span> <?php echo $ar['banos']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Toilette:</span> <?php echo $ar['toilette']; ?></td>
						</tr>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Patio:</span> <?php echo $ar['patio']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Jardín:</span> <?php echo $ar['jardin']; ?></td>
						</tr>
						<tr>
							<td><img src="./images/bullet.png" alt="Info"><span>Balcón:</span> <?php echo $ar['balcon']; ?></td>
							<td><img src="./images/bullet.png" alt="Info"><span>Pileta:</span> <?php echo $ar['pileta']; ?></td>
						</tr>
					</table>
					<br>
					<div>
						<h4><img src="./images/bullet.png" alt="Info">Descripción:</h4>
						<h5><?php echo $ar['descripcion']; ?></h5>
				    </div>
				</div>
			</div>
			<br>
			<div class="inmobiliaria">
				<h1>Contacto Comercial:</h1>
				<br>
				<table>
					<tr>
						<td>
							<table class="InmoInfo">
								<tr>
									<td><img src="./images/bullet.png" alt="Info"><span>Inmobiliaria:</span> <?php echo $ar['NombreInmobiliaria']; ?></td>
									<td><img src="./images/bullet.png" alt="Info"><span>Ficha:</span> <?php echo $ar['CodigoFicha']; ?> </td>
								</tr>
								<tr>
									<td><img src="./images/bullet.png" alt="Info"><span>Domicilio:</span> <?php echo $ar['DomiInmobiliaria']." ".$ar['AlturaInmobiliaria']." ".$ar['PisoInmobiliaria']; ?></td>
									<td><img src="./images/bullet.png" alt="Info"><span>Asesor:</span> <?php echo $ar['contacto']; ?> </td>
								</tr>
								<tr>
									<td><img src="./images/bullet.png" alt="Info"><span>Email:</span> <?php echo $ar['MailInmobiliaria']; ?> </td>
									<td><img src="./images/bullet.png" alt="Info"><span>Web:</span> <?php echo $ar['SitioInmobiliaria']; ?></td>
								</tr>
								<tr>
									<td><img src="./images/bullet.png" alt="Info"><span>Teléfono:</span> <?php echo "(+".$ar['NumeroRegion'].") ".$ar['NumeroTelefono']; ?></td>
									<td></td>
								</tr>
							</table>
						</td>
						<td>
							<div class="InmoContact">
								<div class="logoInmobiliaria">
								<?php
								if (empty($ar['LogoInmobiliaria'])) {
									echo '<img src="./images/nodisponible_inmo.jpg" alt="Sin Imagen">';
								}
								else {
									echo "<img src='./uploads/".$ar['IdImobiliaria']."/".$ar['LogoInmobiliaria']."' alt='Inmobiliaria'>";
								}
								?>
								</div>
									<button class="InmoBtn" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">Contactar Inmobiliaria</button>
							</div>
						</td>
					</tr>
				</table>
				<br>
			</div>
			<br>
			<div class="located">
				<h1>Localización del Inmueble:</h1>
				<br>
				<table>
					<tr>
						<td><img src="./images/bullet.png" alt="Info"><span>Calle:</span> <?php echo $ar['DomiAviso']; ?></td>
						<td><img src="./images/bullet.png" alt="Info"><span>Altura:</span> <?php echo $ar['AlturaAviso']; ?></td>
					</tr>
					<tr>
						<td><img src="./images/bullet.png" alt="Info"><span>Piso:</span> <?php echo $ar['PisoAviso']; ?></td>
						<td><img src="./images/bullet.png" alt="Info"><span>Localidad:</span> <?php echo utf8_encode($ar['Localidad']); ?></td>
					</tr>
					<tr>
						<td><img src="./images/bullet.png" alt="Info"><span>Provincia:</span> <?php echo $ar['Provincia']; ?></td>
						<td><img src="./images/bullet.png" alt="Info"><span>País:</span> Argentina</td>
					</tr>
				</table>
				<br>
			</div>
			<br>
			<div id="map"></div> 
					   <?php 
					   echo "<script type='text/javascript'> \n"; 
					   echo "var address = '".$ar['DomiAviso']." ".$ar['AlturaAviso'].", ".utf8_encode($ar['Localidad']).", ".$ar['Provincia']."' \n";
					   echo "var map = new google.maps.Map(document.getElementById('map'), {  \n";
					   echo "    mapTypeId: google.maps.MapTypeId.ROADMAP, \n";
					   echo "    zoom: 16 \n";
					   echo "}); \n";
					   echo "var geocoder = new google.maps.Geocoder(); \n";
					   echo "geocoder.geocode({ \n";
					   echo "   'address': address \n";
					   echo "},  \n";
					   echo "function(results, status) { \n";
					   echo "   if(status == google.maps.GeocoderStatus.OK) { \n";
					   echo "      new google.maps.Marker({ \n";
					   echo "        position: results[0].geometry.location, \n";
					   echo "         map: map \n";
					   echo "      }); \n";
					   echo "      map.setCenter(results[0].geometry.location); \n";
					   echo "   } \n";
					   echo "}); \n";
					   echo "</script>   \n";
					   ?> 			
			<br>
        </td>
		<td class="content right">	
		</td>
	</tr>
</table>
<?php
		}
?>
<?php
include 'includes/footer.php';
?>