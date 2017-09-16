<?php
session_start();

include 'includes/session.php';


 
require 'libs/FrontController.php';

$_POST['controlador'] ="User" ;

$_POST['accion'] = "getAvisos" ;


FrontController::main();



?>