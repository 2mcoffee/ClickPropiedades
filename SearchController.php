<?php


require 'libs/FrontController.php';

$_POST['controlador'] ="Search" ;

$_POST['accion'] = "listar" ;

$_POST['hasta'] = "15" ;
$_POST['desde'] =  "0" ;

 
FrontController::main();



?>