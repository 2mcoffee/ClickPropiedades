<?php
session_start();

require 'libs/FrontController.php';

$_POST['controlador'] ="Admin" ;
$_POST['accion'] = "altaLocalidad" ;


FrontController::main();

?>