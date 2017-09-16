<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
<table class="content">
	<tr>
		<td class="content left">
		</td>
		<td class="content central">
			<br>
			<div class="login">
				<h1>Registro de Usuario</h1>
				<br>
				<?php
					if (empty($mensaje)) {
						echo '<span>Registre su inmobiliaria para operar.</span><br><br>';
					}
					else {
						echo "<span>".$mensaje."</span><br><br>";
					};
				?>
				<form action="newCustomer.php" method="POST" enctype="multipart/form-data" name="frmRegister" onsubmit="return CheckForm(frmRegister);">
					<img src="./images/user_login.png" alt="Usuario"> <input type="text" name="username" placeholder="Usuario"><br>
					<img src="./images/key_login.png" alt="Clave"> <input type="password" name="password" placeholder="Contraseña"><br>
					<img src="./images/build_login.png" alt="Inmobiliaria"> <input type="text" name="razonsocial" placeholder="Inmobiliaria"><br>
					<img src="./images/cuit_login.png" alt="CUIT"> <input type="text" name="cuit" placeholder="CUIT"><br>
					<img src="./images/contact_login.png" alt="Contacto Comercial"> <input type="text" name="asesor" placeholder="Asesor Comercial"><br>
					<img src="./images/tel_login.png" alt="Codigo de Area"> <input type="text" name="codigo" placeholder="Codigo" style="width:14%;"> <input type="text" name="telefono" placeholder="Telefono" style="width:40%;"><br>
					<img src="./images/mail_login.png" alt="Email"> <input type="text" name="email" placeholder="Email"><br>
					<img src="./images/web_login.png" alt="Sitio Web"> <input type="text" name="web" placeholder="Sitio Web"><br>
					<img src="./images/home_login.png" alt="Provincia"> <select name="provincia" size="1" id="provincia">
						<option value="0" selected="selected" disabled>Provincia</option>
						<?php  echo $salidaProvincia ;?>
					</select><br>
					<img src="./images/fix_login.png" alt="Partido"> <select name="partido" size="1" id="partido">
						<option value="0" selected="selected" disabled>Partido</option>
						<?php  echo $salidaPartido ;?>
					</select><br>
					<img src="./images/fix_login.png" alt="Localidad"> <select name="localidad" size="1" id="localidad">
						<option value="0" selected="selected" disabled>Localidad</option>
						<?php  echo $salidaLocalidad ;?>
					</select><br>
					<img src="./images/fix_login.png" alt="Direccion"> <input type="text" name="calle" placeholder="Calle"><br>
					<img src="./images/fix_login.png" alt="Direccion"> <input type="text" name="altura" placeholder="Altura" style="width:16%;"> <input type="text" name="piso" placeholder="Piso" style="width:16%;"> <input type="text" name="depto" placeholder="Depto" style="width:17%;"><br><br>
					<img src="./images/file_login.png" alt="Logo"> <input type="file" name="logo" accept="image/gif,image/png,image/jpeg"><br><br>
					<input type="reset" value="Limpiar"> <input type="submit" value="Registrarme">
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