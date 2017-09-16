<?php	
/*  ini_set('display_errors', 1);
error_reporting(E_ALL);  */
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
	public function mostrarAcceso()
	{

		/* if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1)  ) 
		{
				$this->view->showInvalido("login.php" , "Su sesión ha finalizado, por favor vuelva a ingresar al sistema");
				session_destroy();
		}
		else
		{
		echo "usuario :" ;
		echo $_SESSION['User'] ;
			$this->ingresoSistema($_SESSION['User']) ;
		} */
		
		IF(empty($_SESSION['User']) )
		{
			session_destroy();
			$this->view->showInvalido("login.php","Inicie sesión con su usuario y clave.");
		}
		else
		{
			if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1000)) 
			{
				session_destroy();
				$this->view->showInvalido("login.php"," Su sesión ha finalizado, por favor vuelva a ingresar al sistema");
			}
			else
				$this->ingresoSistema($_SESSION['User']) ; 
		}
			
	}
	private function ingresoSistema($usuario)
	{
		$userRol = $this->model->getClienteRol($usuario);

					while($dataLog = $userRol->fetch() )
					{
						/* echo $dataLog['usuario'] ; echo " - Rol: " ; echo $dataLog['rol']  ; echo " id_usuario: " ;  echo $dataLog['id_usuario']  ;  */
						$rol = $dataLog['rol'] ;
						$id_user = $dataLog['id_usuario']  ; 
						$user = $dataLog['usuario']  ; 
					}	 
					
					if ($rol == "Administrador" ) /*admin*/
					{
/* 					 	$avisosAdmin = $this->model->getAvisosAdmin($id_user, 20, 0) ; 
						$avisoExtra = $this->model->getDataCustomer($id_user) ;
						
						 $dataAdminLog['salidaCentral'] = 	$avisosAdmin ;  
						$dataAdminLog['salidaInfoRol'] =	$avisoExtra ; */
						$this->view->showAdmin("admin.php",  $id_user , $user ) ;
					}
					else
					{
					
						$avisosCustomer =  $this->model->getAvisosCustomer($id_user, 20 , 0 ) ;
						$avisoExtra = $this->model->getDataCustomer($id_user) ;
						$totalMisAvisos = $this->model->totalMisAvisos($id_user) ;
						
						$dataCustomerLog['salidaCentral'] = $avisosCustomer ;
						$dataCustomerLog['salidaInfoRol'] =	$avisoExtra ;
						$dataCustomerLog['salidaTotalRegistros'] =	$totalMisAvisos ;
						$this->view->showUser("user.php" , $dataCustomerLog , $id_user , $user) ;
					}
		
	}
    public function validarUsuario()
    {

		
			$valido = $this->model->clienteValido($_POST['username'] , $_POST['password']);
		
			
			if($valido==404)
			{
				
				$this->view->showInvalido("login.php", "Usuario y/o contraseña inválidos.");
			}
			else
			{
				$enabledAccess = $this->model->enableCustomer($_POST['username'] , $_POST['password']) ;
				
				if($enabledAccess > 0 )
				{
					$this->ingresoSistema($_POST['username'] ) ; 
					
				}
				else
				{	
					$enabledAccessAdmin = $this->model->enableAdmin($_POST['username'] , $_POST['password']) ;
					if($enabledAccessAdmin > 0 )	
						$this->ingresoSistema($_POST['username'] ) ; 
					else	
						$this->view->showInvalido("login.php", "Usuario no habilitado.");
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
		$dataUser = $this->model->getPassword($_POST['username'] , $_POST['email']  ) ;
		$logData['pwd'] = $dataUser ; 
		
		if ($logData['pwd']->rowCount() <=  0 )
			$this->view->showInvalido("login.php", " No existe usuario y mail en nuestra base ") ;
		else
		{
			while($des = $logData['pwd']->fetch() )
			{
				$_POST['user'] = $des['usuario'] ; 
				$_POST['email'] = $des['mail'] ; 
				$_POST['password'] = $des['pwd'] ; 
			} 
			require_once 'views/reset_mail.php' ;
			$this->view->showSuccess("success.php", " Por favor revise su email y obtendra su clave")  ; 
		}
		
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

			$this->view->showInvalido("success.php", "Ya existe el usuario ingresado, por favor ingrese otro usuario .") ;
		}
		else
		{
			$register = $this->model->InsertCustomer($_POST['username'],$_POST['password'] ,$_POST['razonsocial'] , $_POST['cuit'] , $_POST['asesor'] ,  $_POST['codigo'] , $_POST['telefono']  , $_POST['email'] , $_POST['web'] , $_POST['calle'] , $_POST['altura'] , $_POST['piso'] , $_POST['depto']  ,   $_POST['localidad'] , $alto, $ancho , $id_rol , $habilitada, $tipo_plan ) ;
			if(is_null($register))
				$this->view->showSuccess("success.php", "Se ha registrado correctamente" );
			else
			{
				$this->view->showInvalido("success.php", "Ha ocurrido un error por favor pongase en contacto con el administrador.") ;
			}
		}

	}

}
?>