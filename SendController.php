<?php
if(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["telefono"]) && isset($_POST["email"]) && isset($_POST["ficha"]) && isset($_POST["comentario"]) ){
$to = $_POST["email"];
$subject = "Compucasas REF:".$_POST["ficha"];
$contenido .= "Nombre: ".$_POST["nombre"]."\n";
$contenido .= "Apellido: ".$_POST["apellido"]."\n";
$contenido .= "Telefono: ".$_POST["telefono"]."\n";
$contenido .= "Email: ".$_POST["email"]."\n";
$contenido .= "Comentario: ".$_POST["comentario"]."\n";
$header = "From: no-reply@compucasas.tk\nReply-To:".$_POST["email"]."\n";
$header .= "Mime-Version: 1.0\n";
$header .= "Content-Type: text/plain";
if(mail($to, $subject, $contenido ,$header)){
echo "<script type='text/javascript'>history.go(-1);</script>";
}
}
?>