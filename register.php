<?php


 require_once 'libs/FrontController.php'; 

 if (is_null($mensaje) )
 {
$_POST['controlador'] ="Log" ;
}
else
{
$_POST['controlador'] ="Postback" ;
$_POST['mensaje'] = $mensaje ; 
}
$_POST['accion'] = "ShowRegister" ;

 
FrontController::main();

?>