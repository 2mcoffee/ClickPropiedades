<?php
include 'includes/session.php';

session_start();

require_once 'libs/FrontController.php'; 

$_POST['controlador'] ="User" ;

$_POST['accion'] = "mostrarAltaNuevoAviso" ;

FrontController::main();

?>