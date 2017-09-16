<?php
session_start();

require 'libs/FrontController.php';

$_POST['controlador'] ="Log" ;

$_POST['accion'] = "validarUsuario" ;

$usuario = $_POST['usuario'] ;
$pwd=$_POST['password'] ;

FrontController::main();

?>