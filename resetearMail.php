<?php

require_once 'libs/FrontController.php'; 
 

 
$_POST['controlador'] ="Log" ;

$_POST['accion'] = "showPwd" ;
 
FrontController::main();

?>