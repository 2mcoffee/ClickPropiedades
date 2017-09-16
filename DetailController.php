<?php
session_start(); 

require 'libs/FrontController.php';

$_POST['controlador'] ="Detail" ;

$_POST['accion'] = "listar" ;

$get = $_GET['destino'] ;
 
FrontController::main();

?>