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
				<h1>Publicar Nuevo Aviso</h1>
				<br>
				<form action="publicar.php" method="POST" name="frmPublish" enctype="multipart/form-data"  onsubmit="return CheckForm(frmPublish);">
					<input type="hidden" name="idInmobiliaria" value="<?php echo $_SESSION['IdUser']; ?>">
					<h2><img src="./images/money_login.png" alt="Operacion"> Operación:</h2><br>
					<select name="tipoinmueble" size="1" id="tipoinmueble">
						<option value="0" selected="selected" disabled>Tipo de Inmueble</option>
						<?php  echo $salidaEdificaciones ;?>
					</select><br>
					<input type="text" name="ficha" placeholder="Código de Ficha"><br>
					<select name="operacion" size="1" id="operacion">
						<option value="0" selected="selected" disabled>Operación</option>
						<?php  echo $salidaOperaciones ;?>
					</select><br>
					<select name="moneda" size="1" id="moneda" style="width:30%">
						<option value="0" selected="selected" disabled>Moneda</option>
						<?php  echo $salidaMoneda ;?>
					</select> <input type="text" name="precio" placeholder="Precio" style="width:29%"><br><br>
					<h2><img src="./images/home_login.png" alt="Ubicacion"> Ubicación:</h2><br>
					<select name="provincia" size="1" id="provincia">
						<option value="0" selected="selected" disabled>Provincia</option>
						<?php  echo $salidaProvincia ;?>
					</select><br>
					<select name="partido" size="1" id="partido">
						<option value="0" selected="selected" disabled>Partido</option>
						<?php  echo $salidaPartido ;?>
					</select><br>
					<select name="localidad" size="1" id="localidad">
						<option value="0" selected="selected" disabled>Localidad</option>
						<?php  echo $salidaLocalidad ;?>
					</select><br>
					<input type="text" name="calle" placeholder="Calle"><br>
					<input type="text" name="altura" placeholder="Altura" style="width:16%;"> <input type="text" name="piso" placeholder="Piso" style="width:16%;"> <input type="text" name="depto" placeholder="Depto" style="width:17%;"><br><br>
					<h2><img src="./images/detail_login.png" alt="Caracteristicas"> Características:</h2><br>
					<input type="text" name="suptotal" placeholder="Sup. Total" style="width:28%"> <input type="text" name="supcubierta" placeholder="Sup. Cubierta" style="width:27%"><br>
					<input type="text" name="ambientes" placeholder="Ambientes" style="width:28%;"> <input type="text" name="dormitorios" placeholder="Dormitorios" style="width:27%;"><br>
					<input type="text" name="banos" placeholder="Baños" style="width:28%;"> <input type="text" name="toilette" placeholder="Toilette" style="width:27%;"><br>
					<input type="text" name="antiguedad" placeholder="Antigüedad" style="width:16%;"> <input type="text" name="estado" placeholder="Estado" style="width:16%;"> <input type="text" name="luminosidad" placeholder="Luminosidad" style="width:17%;"><br><br>
					<h2><img src="./images/extra_login.png" alt="Detalles"> Detalles:</h2><br>
					<select name="terraza" size="1" id="terraza" style="width:21%;">
						<option value="No" selected="selected" disabled>Terraza</option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select> 
					<select name="balcon" size="1" id="balcon" style="width:21%;">
						<option value="No" selected="selected" disabled>Balcón</option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select> 
					<select name="patio" size="1" id="patio" style="width:21%;">
						<option value="No" selected="selected" disabled>Patio</option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select><br>
					<select name="pileta" size="1" id="pileta" style="width:21%;">
						<option value="No" selected="selected" disabled>Pileta</option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select>
					<select name="jardin" size="1" id="jardin" style="width:21%;">
						<option value="No" selected="selected" disabled>Jardín</option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select> 
					<select name="garage" size="1" id="garage" style="width:21%;">
						<option value="No" selected="selected" disabled>Garage</option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select><br>
					<select name="seguridad" size="1" id="seguridad" style="width:32%;">
						<option value="No" selected="selected" disabled>Seguridad</option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select> 
					<select name="profesional" size="1" id="profesional" style="width:32%;">
						<option value="No" selected="selected" disabled>Profesional</option>
						<option value="No">No</option>
						<option value="Si">Si</option>
					</select>
					<br>
					<textarea name="descripcion" style="width:60%;" rows="6" placeholder="Descripción del Inmueble"></textarea><br><br>
					<h2><img src="./images/file_login.png" alt="Imagenes"> Imágenes:</h2><br>
					<span>Imagen 1:</span> <input type="file" name="imagen1" accept="image/gif,image/png,image/jpeg"><br>
					<span>Imagen 2:</span> <input type="file" name="imagen2" accept="image/gif,image/png,image/jpeg"><br>
					<span>Imagen 3:</span> <input type="file" name="imagen3" accept="image/gif,image/png,image/jpeg"><br>
					<span>Imagen 4:</span> <input type="file" name="imagen4" accept="image/gif,image/png,image/jpeg"><br>
					<span>Imagen 5:</span> <input type="file" name="imagen5" accept="image/gif,image/png,image/jpeg"><br>
					<br><br>
					<input type="reset" value="Limpiar"> <input type="submit" value="Publicar">
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