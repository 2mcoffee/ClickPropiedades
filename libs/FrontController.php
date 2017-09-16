<?php
class FrontController
{
function __construct()
    {		
    }

    static function main()
    {
		require_once 'libs/Configuracion.php'; 
		require_once 'libs/SPDO.php';
        require_once 'libs/View.php'; 
        require 'config.php'; 
		
		
        if(! empty($_POST['controlador']))
            $controllerName = $_POST['controlador'] . 'Controller';
        else
             $controllerName = "IndexController";
			 

        if(! empty($_POST['accion']))
              $actionName = $_POST['accion'];
        else
              $actionName = "listar";
			  

        $controllerPath = $config->get('controllersFolder') . $controllerName . '.php';



        if(is_file($controllerPath))
              require $controllerPath;
        else
              die('El controlador no existe - 404 not found');
			
        if (is_callable(array($controllerName, $actionName)) == false)
        {
			trigger_error ($controllerName . '->' . $actionName . '` no existeeeeee', E_USER_NOTICE);
            return false;
        }

		$controller = new $controllerName();
		$controller->$actionName();
		
		
		
		unset($controller) ;
		unset($controllerName) ;
		/* if (class_exists($controllerName) != true)
		{
		echo"dddd";
			
		}
		else	
		{
			echo $actionName ;
			echo $controllerName ; 
			$controllerName->$actionName();
        } */
    }
}
?>