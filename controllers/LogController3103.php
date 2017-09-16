<?php		
class LogController
{
	function __destruct ( )
	{
	}
	
    function __construct()
    {
		   $this->view = new View();
		   require 'models/LogModel.php';
		   $this->model = new LogModel();
    }
    public function validarUsuario()
    {

		
		$valido = $this->model->clienteValido($_POST['username'] , $_POST['password']);
	
		
		if($valido==404)
		{
			
			$this->view->showInvalido("login.php", "Su usuario y contraseña no coinciden por favor reintente ingresa correctamente sus datos. Muchas gracias! ");
		}
		else
		{
			$enabledAccess = $this->model->enableCustomer($_POST['username'] , $_POST['password']) ;
			
			if($enabledAccess > 0 )
			{
			
				$userRol = $this->model->getClienteRol($_POST['username'] , $_POST['password']);

				while($dataLog = $userRol->fetch() )
				{
					echo $dataLog['usuario'] ; echo " - Rol: " ; echo $dataLog['rol']  ; echo " id_usuario: " ;  echo $dataLog['id_usuario']  ; 
					$rol = $dataLog['rol'] ;
					$id_user = $dataLog['id_usuario']  ; 
					$user = $dataLog['usuario']  ; 
				}	 
				
				if ($rol == "Administrador" ) /*admin*/
				{
				
					$avisosAdmin = $this->model->getAvisosAdmin($id_user, 20, 0) ;
					$dataAdminLog['avisosAdmin'] = $avisosAdmin ; 
					$this->view->showAdmin("admin.php", $dataAdminLog , $id_user , $user ) ;
				}
				else
				{
				
					$avisosCustomer =  $this->model->getAvisosCustomer($id_user, 20 , 0 ) ;
					//$_SESSION['username']=$username;
					$dataCustomerLog['salidaCentral'] = $avisosCustomer ;
					
	
					
					
					$this->view->showUser("user.php" , $dataCustomerLog , $id_user , $user) ;
				}
			}
			else
			{	

				$this->view->showInvalido("login.php", "Ud no ha sido habilitado para operar. Por favor pongase en contacto con el Administrador.");
			}
		}		
		
    }

	public function showRegister()
	{
		$provincias = $this->model->listadoProvincias() ;
		$data['provincias'] =$provincias ;
		$this->view->showInitialRegister("registerview.php",  $data ) ;
	}
	public function showPwd()
	{
/* 		require 'models/LogModel.php';
        $cleanPwd = new LogModel();
		$dataUser = $cleanPwd->getPassword($_POST['usuario'] , $_POST['mail']  )
		$logData['pwd'] = $dataUser ; */
		/*$this->view->showPwd("")  a que pagina retorno  */
	}
	public function altaInmobiliaria ()
	{
	
		
		$alto= 400 ;
		$ancho= 300 ;
		$id_rol = 2;  /*Inmobiliaria*/
		$habilitada=0; /*no habilitada*/
		$tipo_plan = 1; /*plan por defecto*/

		/*controlar usuarios no repetidos */	
		
		
		$exists = $this->model->checkUser($_POST['username'],$_POST['password']) ;
		
		$register = null ; 
		$cel = null ; 

	
		
		if ($exists >0)
		{

			$this->view->showInvalido("../register.php", "YA existe el usuario ingresado.") ;
		}
		else
		{
			$register = $this->model->InsertCustomer($_POST['username'],$_POST['password'] ,$_POST['razonsocial'] , $_POST['cuit'] , $_POST['asesor'] ,  $_POST['codigo'] , $_POST['telefono'] , $_POST['cel'] , $_POST['email'] , $_POST['web'] , $_POST['calle'] , $_POST['altura'] , $_POST['piso'] ,    $_POST['localidad'] , $alto, $ancho , $id_rol , $habilitada, $tipo_plan ) ;
			if(is_null($register))
				$this->view->showSuccess("successfull.php", 1);
			else
			{
				$this->view->showInvalido("../register.php", "Ha ocurrido un error por favor pongase en contacto con el administrador.") ;
			}
		}

	}

}
?>