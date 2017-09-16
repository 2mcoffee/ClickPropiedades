<?php
if(isset($_POST['user']) && isset($_POST['email']) && isset($_POST['password']) )
{ 
	$to = $_POST["email"];
	$subject = "Click Propiedades - Recordatorio de Clave";
	$contenido = "Usuario: ".$_POST['user']."\n";
	$contenido .= "Email: ".$_POST['email']."\n\n";
	$contenido .= "Clave: ".$_POST['password']."\n\n";
	$header = "From: no-reply@clickpropiedades.com\nReply-To:".$_POST["email"]."\n";
	$header .= "Mime-Version: 1.0\n";
	$header .= "Content-Type: text/plain";
	
	mail($to, $subject, $contenido ,$header) ;
 } 
?>