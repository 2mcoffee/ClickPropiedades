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
				<h1>Inicio de Sesión</h1>
				<br>
				<?php
					if (empty($mensaje)) {
						echo '';
					}
					else {
						echo "<span>".$mensaje."</span><br><br>";
					};
				?>
				<form action="loginUser.php" method="post" name="frmLogin" onsubmit="return CheckForm(frmLogin);">
				<img src="./images/user_login.png" alt="Usuario"> <input type="text" name="username" placeholder="Usuario"><br>
				<img src="./images/key_login.png" alt="Clave"> <input type="password" name="password" placeholder="Contraseña"><br>
				<input type="submit" value="Ingresar">
				<br>
				<br>
				<span><a href="./reset.php">● ¿Olvidó su usuario/contraseña?</a></span><br>
				<span><a href="./register.php">● Registrarse</a></span>
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