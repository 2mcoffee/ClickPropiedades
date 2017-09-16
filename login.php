<?php
session_start();
 
require 'libs/FrontController.php';

$_POST['controlador'] ="Log" ;

$_POST['accion'] = "mostrarAcceso" ;

FrontController::main();

?>