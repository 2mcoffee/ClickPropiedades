<?php
session_start();

require 'libs/FrontController.php';

$_POST['controlador'] ="Admin" ;
$_POST['accion'] = "Accesos" ;


FrontController::main();

?>