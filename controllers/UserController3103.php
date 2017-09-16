<?php
class Usercontroller
{
    function __construct()
    {
	   $this->view = new View();
	   	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1000)) 
		{
			session_unset();
			session_destroy();	
			$this->view->showInvalido("login.php" , "Su sesión ha finalizado, por favor vuelva a ingresar al sistema");
			exit ;
		}
		else
		$_SESSION['LAST_ACTIVITY']	 = time() ;
	   
    }
	function __destruct ( )
	{}
	
	public function mostrarAlta()
	{
		require 'models/LogModel.php';
        $Logma = new LogModel();
		$provincias = $Logma->listadoProvincias() ;
		$data['provincias'] =$provincias ;
		$this->view->showRegister("register.php", $data ) ;
	}
	public function mostrarAltaNuevoAviso()
	{
		require 'models/UserModel.php';
        $UserMo = new UserModel();
		
		$cantidadAvisosPlan = $UserMo->avisosHabilitados(4) ;
		$cantidadAvisosCargados = $UserMo->avisosCargados(4) ;
		if ($cantidadAvisosCargados < $cantidadAvisosPlan )
		{
			$provincias = $UserMo->listadoProvincias() ;
			$edificaciones = $UserMo->listadoEdificaciones();
			$operaciones = $UserMo->listadoOperaciones();
			$monedas  = $UserMo->listadoMonedas() ;
			
			$data['provincias'] = $provincias ;
			$data['edificaciones'] = $edificaciones ;
			$data['operaciones'] = $operaciones ;
			$data['monedas'] = $monedas ; 
			$this->view->showPublish("newPublish.php", $data) ;
		}
		else
		{
				echo "Ha superado la cantidad de avisos cargados que tiene permitido. Pongase en contacto con ClickPropiedades";

				$this->getAvisos();  /*$this->view->showInvalido("user.php", "Ha superado la cantidad de avisos cargados que tiene permitido. Pongase en contacto con ClickPropiedades");*/
				
		}	
	}
	
	public function altaAviso()
	{
		require 'models/UserModel.php';
        $user = new UserModel();
		/* 
		$_POST['$operacion'] ;
		$_POST['$moneda'] ; */
		
		
		/* $_POST['$localidad'] ; */
		
		/*$_POST['$calle'];*/
		/*$_POST['$altura'] ;*/
		/*$_POST['$piso'] ; */
		
	//	$_POST['$depto'] ; no usO
		
		
		/*$_POST['$suptotal'] ;*/
		/*$_POST['$supcubierta'] ;*/
		/*$_POST['$ambientes'] ;*/
		/*$_POST['$dormitorios'] ;*/
		/*$_POST['$banos'] ;*/
		/*$_POST['$toilette'] ;*/
		/*$_POST['$antiguedad'] ;*/
		/*$_POST['$estado'] ;*/
		/*$_POST['$luminosidad'] ;*/
		
		/*$_POST['$terraza'] ;*/
		/*$_POST['$balcon'] ;*/
		/*$_POST['$´patio'] ;*/
		/*$_POST['$pileta'] ;*/
		/*$_POST['$profesional'] ;*/
		
		
		
		
	/* 	$_POST['id_tipo_inmueble'],
		$_POST['$seguridad'] ,
		$_POST['$garage'] ,
		$_POST['$jardin'],
		$_POST['$codigoficha'],
		$_POST['$descripcion'] ,
		 */
		/*$_POST['$id_inmobiliaria'] , ?? IDENTIFICAR LA SESSION? O DE ALGUNA FORMA*/
		/*$_POST['$id_caracteristica'] , $_POST['$id_dato_basico'] , $_POST['$id_domicilio'] , CORROBORAR MANERA DE INSERTAR*/ 

		
	
		
		
		
		$idAviso =  $user->insertAviso($_POST['tipoinmueble'], $_POST['operacion'] , $_POST['moneda'] , $_POST['precio']  , $_POST['ambientes'], $_POST['dormitorios'], $_POST['antiguedad'], $_POST['estado'], $_POST['profesional'], $_POST['terraza'], $_POST['luminosidad'], $_POST['seguridad'] , $_POST['suptotal'], $_POST['supcubierta'], $_POST['banos'], $_POST['toilette'] , $_POST['garage'] , $_POST['balcon'], $_POST['patio'], $_POST['jardin'], $_POST['pileta'] , $_POST['calle'], $_POST['altura'] , $_POST['piso']  , 3 /*$_POST['$id_inmobiliaria'] */, $_POST['id_caracteristica'] , $_POST['id_dato_basico'] , $_POST['ficha'] , 1 /* $_POST['$localidad'] */, $_POST['id_domicilio'] , $_POST['descripcion'] , date("Y-m-d H:i:s:m") /* $_POST['$fecha_alta'] */ , 1 /*$_POST['$id_estadoAviso']*/ ) ;
		if (is_null($idAviso) or is_string($idAviso) ) /*hubo un error*/
			$this->view->showInvalido("user.php", $idAviso ) ;
		else
			$this->view->showSuccess("insertPicture.php", $idAviso ) ; 
	
	}
	public function altaFotos()
	{
		if (!empty ($_FILES['foto1']['name'] ) ) 
		{
			$addPic =  $model->insertFotos($_FILES['foto1']['name']) ;
			if (is_null($addPic) or is_string($addPic) )
			{
				$this->view->showInvalido("user.php", $addPic ) ;
				exit ;
			}
		}	
		$addPic = null ; 
		
		if (!empty ($_FILES['foto2']['name'] ) ) 
		{
			$addPic =  $model->insertFotos($_FILES['foto2']['name']) ;
			if (isset($addPic) or is_string($addPic) )
			{
				$this->view->showInvalido("user.php", $addPic ) ;
				exit ;
			}
		}	
			$addPic = null ; 
		
		if (!empty ($_FILES['foto3']['name'] ) ) 
		{
			$addPic =  $model->insertFotos($_FILES['foto3']['name']) ;
			if (isset($addPic) or is_string($addPic) )
			{
				$this->view->showInvalido("user.php", $addPic ) ;
				exit ;
			}
		}
			$addPic = null ; 
		
		if (!empty ($_FILES['foto4']['name'] ) ) 
		{
			$addPic =  $model->insertFotos($_FILES['foto4']['name']) ;
			if (isset($addPic) or is_string($addPic) )
			{
				$this->view->showInvalido("user.php", $addPic ) ;
				exit ;
			}
		}	
			$addPic = null ; 
		
		if (!empty ($_FILES['foto5']['name'] ) ) 
		{
			$addPic =  $model->insertFotos($_FILES['foto5']['name']) ;
			if (isset($addPic) or is_string($addPic) )
			{
				$this->view->showInvalido("user.php", $addPic ) ;
				exit ;
			}
		}	

		$this->view->showSuccess("user.php","Las fotos se han cargado exitosamente.") ;
	}
	public function actualizarPerfilUsuario()
	{
		require 'models/UserModel.php';
        $userModel = new UserModel();
		$userModel->updateProfile() ;
		
	}
	public function getPerfilUsuario()
	{
	
		 require 'models/UserModel.php';
         $userPerfil = new UserModel();
		 $perfilUsuario = $userPerfil->getUserProfile(4 /*id_usuario*/);
		 $data['perfil'] = $perfilUsuario  ;
		$this->view->showSuccess("userProfile.php" , null)  ;
		
	}
	public function getAvisos()
	{
		 require_once 'models/UserModel.php';
         $userAvisos = new UserModel();
		 $avisos = $userAvisos->getAvisosCustomer(4 , 20, 0) ;
		 $dataavisos['salidaCentral'] = $avisos ;
		 $this->view->showUser("user.php" , $dataavisos , 4 , "quemado") ;
	}
}
?>