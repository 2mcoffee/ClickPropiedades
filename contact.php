<?php
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ){
	if (isset($_POST['name']) AND isset($_POST['email']) AND isset($_POST['telephone']) AND isset($_POST['subject']) AND isset($_POST['message'])) {
		$to = "web@clickpropiedades.com";
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
		$message .= "Nombre y Apellido: ".filter_var($_POST['name'], FILTER_SANITIZE_STRING)."\n\n";
		$message .= "Email: ".filter_var($_POST['email'], FILTER_SANITIZE_STRING)."\n\n";
		$message .= "Telefono: ".filter_var($_POST['telephone'], FILTER_SANITIZE_STRING)."\n\n";
		$message .= "Mensaje: ".filter_var($_POST['message'], FILTER_SANITIZE_STRING)."\n\n";
		$sent = email($to, $email, $name, $subject, $message);
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
	$header[] = "From: no-reply@clickpropiedades.com\nReply-To:".$_POST["email"]."\n";
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
<table class="content">
	<tr>
		<td class="content left">
		</td>
		<td class="content central">
		<div class="rules">
			<h1>Contacto</h1>
			Si tienes alguna consulta o sugerencia sobre nuestro sitio, no dudes en hacérnosla llegar. 
			Tus observaciones y recomendaciones nos son de gran utilidad para continuar mejorando, día a día, nuestro servicio. 
			Si deseas denunciar o reportar alguna publicación incorrecta o a algún anunciante del sitio también puedes hacerlo desde el presente formulario de contacto.
			<br><br>
			<h2>¡Tus comentarios siempre son bienvenidos!</h2>
			<br><br>
		</div>
		<div class="alert"></div>
		<div class="writeus">
			<form id="form" action="" method="post">
				<div>
					<input placeholder="Nombre y Apellido" type="text" name="name" required id="name">
				</div>
				<div>
					<input placeholder="Email" type="email" name="email" required id="email">
				</div>
				<div>
					<input placeholder="Telefono" type="text" name="telephone" required id="telephone">
				</div>
				<div>
					<input placeholder="Asunto" type="text" name="subject" required id="subject">
				</div>
				<div>
					<textarea placeholder="Ingrese aqui su consulta" name="message" required id="message"></textarea>
				</div>
				<br>
				<div>
					<input type="reset" value="Limpiar"> <button name="submit" type="submit" id="submit">Enviar</button>
				</div>
			</form>
		</div>
		</td>
		<td class="content right">
		</td>
	</tr>
</table>
<?php
include 'includes/footer.php';
?>
		