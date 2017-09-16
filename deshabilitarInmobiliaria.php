<?php
session_start();

require 'libs/FrontController.php';

$_POST['controlador'] ="Admin" ;
$_POST['accion'] = "estadoInmobiliaria" ;
$_POST['habilitada'] = false ;

FrontController::main();

?>