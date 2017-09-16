<?php
session_start();

 
require 'libs/FrontController.php';

$_POST['controlador'] ="User" ;

$_POST['accion'] = "updateAviso" ;


FrontController::main();



?>