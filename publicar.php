<?php

include 'includes/session.php';

session_start();

set_time_limit(0) ;

require_once 'libs/FrontController.php'; 

$_POST['controlador'] ="User" ;

$_POST['accion'] = "altaAviso" ;

 
FrontController::main();

?>