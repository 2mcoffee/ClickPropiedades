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
				<h1>Datos de Usuario</h1>
				<br>
				<form action="updateProfile.php" method="POST" enctype="multipart/form-data" name="frmUpdateProfile" onsubmit="return CheckForm(frmUpdateProfile);">
					<img src="./images/build_login.png" alt="Razon Social"> <input type="text" name="razonsocial" value="<?php echo $salidarazonSocial; ?>" placeholder="Razon Social"><br>
					<img src="./images/cuit_login.png" alt="CUIT"> <input type="text" name="cuit" value="<?php echo $salidacuit; ?>" placeholder="CUIT"><br>
					<img src="./images/contact_login.png" alt="Asesor Comercial"> <input type="text" name="asesor" value="<?php echo $salidaasesorComercial; ?>" placeholder="Asesor Comercial"><br>
					<img src="./images/tel_login.png" alt="Codigo de Area"> <input type="text" name="codigo" value="<?php echo $salidaregion; ?>" placeholder="Codigo" style="width:14%;"> <input type="text" name="telefono" value="<?php echo $salidanumero; ?>" placeholder="Telefono" style="width:40%;"><br>
					<img src="./images/mail_login.png" alt="Email"> <input type="text" name="email" value="<?php echo $salidamail; ?>" placeholder="Email"><br>
					<img src="./images/web_login.png" alt="Sitio Web"> <input type="text" name="web"
					<?php
					if (empty($salidasite)) {
						echo 'placeholder="Sitio Web">';
					}
					else {
						echo 'value="'.$salidasite.'">';
					};
					?>					
					<br>
					<img src="./images/home_login.png" alt="Provincia"> <select name="provincia" size="1" id="provincia">
						<option value="0" disabled>Provincia</option>
						<option value="<?php echo $salidaIdProvincia; ?>" selected="selected"><?php echo $salidaprovincia; ?></option>
						<?php  echo $salidaProvincia ;?>
					</select><br>
					<img src="./images/fix_login.png" alt="Partido"> <select name="partido" size="1" id="partido">
						<option value="0" disabled>Partido</option>
						<option value="<?php echo $salidaIdPartido; ?>" selected="selected"><?php echo $salidapartido; ?></option>
						<?php  echo $salidaPartido ;?>
					</select><br>
					<img src="./images/fix_login.png" alt="Localidad"> <select name="localidad" size="1" id="localidad">
						<option value="0" disabled>Localidad</option>
						<option value="<?php echo $salidaIdLocalidad; ?>" selected="selected"><?php echo $salidalocalidad; ?></option>
						<?php  echo $salidaLocalidad ;?>
					</select><br>
					<img src="./images/fix_login.png" alt="Direccion"> <input type="text" name="calle" value="<?php echo $salidadireccion; ?>" placeholder="Calle"><br>
					<img src="./images/fix_login.png" alt="Direccion"> <input type="text" name="altura" value="<?php echo $salidaaltura; ?>" placeholder="Altura" style="width:16%;"> 
					<input type="text" name="piso" 
					<?php
					if (empty($salidapiso)) {
						echo 'placeholder="Piso"';
					}
					else {
						echo 'value="'.$salidapiso.'"';
					};
					?> style="width:16%;"> 
					<input type="text" name="depto" 
					<?php
					if (empty($salidadepto)) {
						echo 'placeholder="Depto"';
					}
					else {
						echo 'value="'.$salidadepto.'"';
					};
					?> style="width:17%;"> 
					<br><br>
					<div style="text-align:center;" >
					<?php
					if (empty($salidaurl_log)) {
							echo '<img style="max-width:150px;" src="./images/nodisponible_inmo.jpg" alt="Sin Imagen">';
						}
						else {
							echo "<img style='max-width:150px; max-height: 75px;' src='./uploads/".$salidaidInmobiliaria."/".$salidaurl_log."' alt='".$salidarazonSocial."'>";
						}
					?>
					</div>
					<br>
					<img src="./images/file_login.png" alt="Logo"> <input type="file" name="logo" accept="image/gif,image/png,image/jpeg"><br><br>
					<input type="button" onclick="history.back();" value="Volver"> <input type="submit" value="Actualizar">
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