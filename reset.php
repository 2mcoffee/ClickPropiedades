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
				<h1>Cambio de Clave</h1>
				<br>
				<form action="resetearMail.php" method="post" enctype="multipart/form-data" name="frmReset" onsubmit="return CheckForm(frmReset);">
				<img src="./images/user_login.png" alt="Usuario"> <input type="text" name="username" placeholder="Usuario"><br>
				<img src="./images/email_login.png" alt="Email"> <input type="text" name="email" placeholder="Email"><br>
				<input type="submit" value="Solicitar">
				<br>
				<br>
				<span><a href="./login.php">● Ingresar al sitio</a></span><br>
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