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
		</td>
		<td class="content central">
			<br>
			<div class="login">
				<h1>Editar Aviso</h1>
				<br>
				<form action="updateAviso.php" method="POST" name="frmPublish" enctype="multipart/form-data"  onsubmit="return CheckForm(frmPublish);">
					<input type="hidden" name="idInmobiliaria" value="<?php echo $salidaidimobiliaria ; ?>">
					<input type="hidden" name="idAviso" value="<?php echo $salidaidaviso ; ?>">
					<h2><img src="./images/money_login.png" alt="Operacion"> Operación:</h2><br>
					<select name="tipoinmueble" size="1" id="tipoinmueble">
						<option value="0" disabled>Tipo de Inmueble</option>
						<option value="<?php echo $salidaidtipoinmueble; ?>" selected="selected"><?php echo $salidatipoinmueble; ?></option>
						<?php  echo $salidaEdificaciones ;?>
					</select><br>
					<input type="text" name="ficha" value="<?php echo $salidacodigoficha; ?>" placeholder="Código de Ficha"><br>
					<select name="operacion" size="1" id="operacion">
						<option value="0" disabled>Operación</option>
						<option value="<?php echo $salidaidoperacion; ?>" selected="selected"><?php echo $salidaoperacion; ?></option>
						<?php  echo $salidaOperaciones ;?>
					</select><br>
					<select name="moneda" size="1" id="moneda" style="width:30%">
						<option value="0" disabled>Moneda</option>
						<option value="<?php echo $salidaidmoneda; ?>" selected="selected"><?php echo $salidamoneda; ?></option>
						<?php  echo $salidaMoneda ;?>
					</select> <input type="text" name="precio" value="<?php echo $salidaprecio; ?>" placeholder="Precio" style="width:29%"><br><br>
					<h2><img src="./images/home_login.png" alt="Ubicacion"> Ubicación:</h2><br>
					<select name="provincia" size="1" id="provincia">
						<option value="0" disabled>Provincia</option>
						<option value="<?php echo $salidaIdProvincia; ?>" selected="selected"><?php echo $salidaprovincia; ?></option>
						<?php  echo $salidaProvincia ;?>
					</select><br>
					<select name="partido" size="1" id="partido">
						<option value="0" disabled>Partido</option>
						<option value="<?php echo $salidaIdPartido; ?>" selected="selected"><?php echo $salidapartido; ?></option>
						<?php  echo $salidaPartido ;?>
					</select><br>
					<select name="localidad" size="1" id="localidad">
						<option value="0" disabled>Localidad</option>
						<option value="<?php echo $salidaIdLocalidad; ?>" selected="selected"><?php echo $salidalocalidad; ?></option>
						<?php  echo $salidaLocalidad ;?>
					</select><br>
					<input type="text" name="calle" value="<?php echo $salidacalle; ?>" placeholder="Calle"><br>
					<input type="text" name="altura" value="<?php echo $salidaaltura; ?>" placeholder="Altura" style="width:16%;"> <input type="text" name="piso" value="<?php echo $salidapiso; ?>" placeholder="Piso" style="width:16%;"> <input type="text" name="depto" value="<?php echo $salidadepto; ?>" placeholder="Depto" style="width:17%;"><br><br>
					<h2><img src="./images/detail_login.png" alt="Caracteristicas"> Características:</h2><br>
					<input type="text" name="suptotal" value="<?php echo $salidasuptotal; ?>" placeholder="Sup. Total" style="width:28%"> <input type="text" name="supcubierta" value="<?php echo $salidasupcubierta; ?>" placeholder="Sup. Cubierta" style="width:27%"><br>
					<input type="text" name="ambientes" value="<?php echo $salidaambientes; ?>" placeholder="Ambientes" style="width:28%;"> <input type="text" name="dormitorios" value="<?php echo $salidadormitorios; ?>" placeholder="Dormitorios" style="width:27%;"><br>
					<input type="text" name="banos" value="<?php echo $salidabanos; ?>" placeholder="Baños" style="width:28%;"> <input type="text" name="toilette" value="<?php echo $salidatoilette; ?>" placeholder="Toilette" style="width:27%;"><br>
					<input type="text" name="antiguedad" value="<?php echo $salidaantiguedad; ?>" placeholder="Antigüedad" style="width:16%;"> <input type="text" name="estado" value="<?php echo $salidaestado; ?>" placeholder="Estado" style="width:16%;"> <input type="text" name="luminosidad" value="<?php echo $salidaluminosidad; ?>" placeholder="Luminosidad" style="width:17%;"><br><br>
					<h2><img src="./images/extra_login.png" alt="Detalles"> Detalles:</h2><br>
					<select name="terraza" size="1" id="terraza" style="width:21%;">
						<option value="No" disabled>Terraza</option>
						<option value="<?php echo $salidaterraza; ?>" selected="selected"><?php echo $salidaterraza; ?></option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select> 
					<select name="balcon" size="1" id="balcon" style="width:21%;">
						<option value="No" disabled>Balcón</option>
						<option value="<?php echo $salidabalcon; ?>" selected="selected"><?php echo $salidabalcon; ?></option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select> 
					<select name="patio" size="1" id="patio" style="width:21%;">
						<option value="No" disabled>Patio</option>
						<option value="<?php echo $salidapatio; ?>" selected="selected"><?php echo $salidapatio; ?></option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select><br>
					<select name="pileta" size="1" id="pileta" style="width:21%;">
						<option value="No" disabled>Pileta</option>
						<option value="<?php echo $salidapileta; ?>" selected="selected"><?php echo $salidapileta; ?></option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select>
					<select name="jardin" size="1" id="jardin" style="width:21%;">
						<option value="No" disabled>Jardín</option>
						<option value="<?php echo $salidajardin; ?>" selected="selected"><?php echo $salidajardin; ?></option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select> 
					<select name="garage" size="1" id="garage" style="width:21%;">
						<option value="No" disabled>Garage</option>
						<option value="<?php echo $salidagarage; ?>" selected="selected"><?php echo $salidagarage; ?></option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select><br>
					<select name="seguridad" size="1" id="seguridad" style="width:32%;">
						<option value="No" disabled>Seguridad</option>
						<option value="<?php echo $salidaseguridad; ?>" selected="selected"><?php echo $salidaseguridad; ?></option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select> 
					<select name="profesional" size="1" id="profesional" style="width:32%;">
						<option value="No" disabled>Profesional</option>
						<option value="<?php echo $salidaprofesional; ?>" selected="selected"><?php echo $salidaprofesional; ?></option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select>
					<br>
					<textarea name="descripcion" value="<?php echo $salidadescripcion ;?>" style="width:60%;" rows="6" placeholder="Descripción del Inmueble"><?php echo $salidadescripcion ;?></textarea><br><br>
					<h2><img src="./images/file_login.png" alt="Imagenes"> Imágenes:</h2><br>
					<div style="text-align:center;" >
					<?php
					if (empty($salidaimagen1)) {
							echo '<img style="max-width:140px;" src="./images/nodisponible_inmo.jpg" alt="Sin Imagen">';
						}
						else {
							echo "<img style='max-width:140px;' src='./uploads/".$salidaidimobiliaria."/".$salidaidaviso."/".$salidaimagen1."' alt='Imagen'>";
						}
					?>
					</div><br>
					<span>Imagen 1:</span> <input type="file" name="imagen1" accept="image/gif,image/png,image/jpeg"><br><br>
					<div style="text-align:center;" >
					<?php
					if (empty($salidaimagen2)) {
							echo '<img style="max-width:140px;" src="./images/nodisponible_inmo.jpg" alt="Sin Imagen">';
						}
						else {
							echo "<img style='max-width:140px;' src='./uploads/".$salidaidimobiliaria."/".$salidaidaviso."/".$salidaimagen2."' alt='Imagen'>";
						}
					?>
					</div><br>
					<span>Imagen 2:</span> <input type="file" name="imagen2" accept="image/gif,image/png,image/jpeg"><br><br>
					<div style="text-align:center;" >
					<?php
					if (empty($salidaimagen3)) {
							echo '<img style="max-width:140px;" src="./images/nodisponible_inmo.jpg" alt="Sin Imagen">';
						}
						else {
							echo "<img style='max-width:140px;' src='./uploads/".$salidaidimobiliaria."/".$salidaidaviso."/".$salidaimagen3."' alt='Imagen'>";
						}
					?>
					</div><br>
					<span>Imagen 3:</span> <input type="file" name="imagen3" accept="image/gif,image/png,image/jpeg"><br><br>
					<div style="text-align:center;" >
					<?php
					if (empty($salidaimagen4)) {
							echo '<img style="max-width:140px;" src="./images/nodisponible_inmo.jpg" alt="Sin Imagen">';
						}
						else {
							echo "<img style='max-width:140px;' src='./uploads/".$salidaidimobiliaria."/".$salidaidaviso."/".$salidaimagen4."' alt='Imagen'>";
						}
					?>
					</div><br>
					<span>Imagen 4:</span> <input type="file" name="imagen4" accept="image/gif,image/png,image/jpeg"><br><br>
					<div style="text-align:center;" >
					<?php
					if (empty($salidaimagen5)) {
							echo '<img style="max-width:140px;" src="./images/nodisponible_inmo.jpg" alt="Sin Imagen">';
						}
						else {
							echo "<img style='max-width:140px;' src='./uploads/".$salidaidimobiliaria."/".$salidaidaviso."/".$salidaimagen5."' alt='Imagen'>";
						}
					?>
					</div><br>
					<span>Imagen 5:</span> <input type="file" name="imagen5" accept="image/gif,image/png,image/jpeg"><br>
					<br><br>
					<input type="button" onclick="history.back();" value="Cancelar"> <input type="submit" value="Actualizar">
				</form>
			</div>
			<br>
		</td>
		<td class="content right">
		</td>
	</tr>
</table>
<?php
include 'includes/footer.php';
?>