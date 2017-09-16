<?php
/* ini_set('display_errors', 1); // set to 0 when not debugging
ini_set('gd.jpeg_ignore_warning', 1); */
ini_set('memory_limit', '128M') ;
set_time_limit(0) ;
//error_reporting(E_ALL);

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

		/*$_POST['$id_inmobiliaria'] , ?? IDENTIFICAR LA SESSION? O DE ALGUNA FORMA*/
		/*$_POST['$id_caracteristica'] , $_POST['$id_dato_basico'] , $_POST['$id_domicilio'] , CORROBORAR MANERA DE INSERTAR*/ 

		/*  Echo "<pre>"; 
print_R($_POST) ;
print_R($_FILES);  */
		
		$idAviso =  $user->insertAviso($_POST['tipoinmueble'], $_POST['operacion'] , $_POST['moneda'] , $_POST['precio']  , $_POST['ambientes'], $_POST['dormitorios'], $_POST['antiguedad'], $_POST['estado'], $_POST['profesional'], $_POST['terraza'], $_POST['luminosidad'], $_POST['seguridad'] , $_POST['suptotal'], $_POST['supcubierta'], $_POST['banos'], $_POST['toilette'] , $_POST['garage'] , $_POST['balcon'], $_POST['patio'], $_POST['jardin'], $_POST['pileta'] , $_POST['calle'], $_POST['altura'] , $_POST['piso']  ,  $_POST['depto'] , 3 /*$_POST['$id_inmobiliaria'] */, $_POST['ficha'] , 1 /* $_POST['$localidad'] */ , $_POST['descripcion'] , date("Y-m-d H:i:s:m") /* $_POST['$fecha_alta'] */ , 1 /*$_POST['$id_estadoAviso']*/ ) ;
		
		if (is_null($idAviso) or is_string($idAviso) ) /*hubo un error*/
		{
			/* echo "entre por dopnde no debia" ;
			$this->view->showInvalido("user.php", $idAviso ) ; */
			
			
			$this->altaFotos(3 , $idAviso) ; 
			$this->view->showSuccess("success.php", $idAviso ) ; 
		}
		else
		{
			echo "else" ; 
			$this->altaFotos($idAviso) ; 
			$this->view->showSuccess("insertPicture.php", $idAviso ) ; 
		}	
	
	}
	private function poseeImagenes()
	{
		if (empty($_FILES['imagen1']['name']) )
			if (empty($_FILES['imagen2']['name']) )
				if (empty($_FILES['imagen3']['name']) )
					if (empty($_FILES['imagen4']['name']) )
						if (empty($_FILES['imagen5']['name']) )
							return false ;
							
		return true ;
	}
	private function crearDirectorio($id_inmobiliaria , $id_aviso)
	{
		$dir = 'uploads/'.$id_inmobiliaria.'/'.$id_aviso ;
		if(!file_exists($dir) )
			$dirmake = mkdir( $dir, 0777) ;
		
		return $dir;
	}
	private function obtenerExtension($nombreImagen)
	{
		$ext = explode(".",$nombreImagen) ;
		return end($ext) ;
	}
	private function obtenerNombre($nombreImagen , $extension , $id_aviso)
	{
		$timestamp  = date('Ymdhis'.substr((string)microtime(), 1, 8));  
		$lenExten = strlen($extension)  + 1 ;
		$nNombre = substr($nombreImagen , 0, -$lenExten) ;
		$nNombre = $nNombre.$id_aviso.$timestamp.".".$extension ;
		return $nNombre ;
	}
	
	public function impactarImagen($id_inmobiliaria ,$id_aviso , $nombreImagen , $orden )
	{
		require_once 'models/UserModel.php';
        $userModel = new UserModel();	
		
		if (!empty($_FILES[$nombreImagen]['name']) )
		{
			$alto= 400 ;
			$ancho= 300 ;
		
			$path = $this->crearDirectorio($id_inmobiliaria , $id_aviso ) ; 
			
			$extension = $this->obtenerExtension($_FILES[$nombreImagen]['name'] ) ;
	
			$nuevoNombreImagen = $this->obtenerNombre($_FILES[$nombreImagen]['name'] , $extension , $id_aviso )  ;
	
			if(move_uploaded_file($_FILES[$nombreImagen]['tmp_name'],  $path.'/'.$_FILES[$nombreImagen]['name']  )) 
			{
				$this->resizeImagen($path."/", $_FILES[$nombreImagen]['name'], $alto, $ancho,$nuevoNombreImagen,$extension) ;
				unlink($path."/".$_FILES[$nombreImagen]['name'] ) ;
		
				$userModel->insertFotos($nuevoNombreImagen , $id_aviso , $orden) ;
		
				$orden = $orden + 1 ;
			}
			else 
				"hubo un error al impactar la foto" ;
				
		}
		return $orden ; 
	}
	public function altaFotos($id_inmobiliaria , $id_aviso)
	{
		$dir = 'uploads/'.$id_inmobiliaria.'/'.$id_aviso ;
		
		try{
		
			if($this->poseeImagenes()) 
			{ 
				$ordenFoto = 1 ;
		
				$ordenFoto = $this->impactarImagen($id_inmobiliaria ,$id_aviso, 'imagen1' , $ordenFoto ) ;
		
				
		
				$ordenFoto = $this->impactarImagen($id_inmobiliaria ,$id_aviso, 'imagen2' , $ordenFoto) ;
		
				$ordenFoto = $this->impactarImagen($id_inmobiliaria ,$id_aviso, 'imagen3' , $ordenFoto ) ;
		
				$ordenFoto = $this->impactarImagen($id_inmobiliaria ,$id_aviso, 'imagen4' , $ordenFoto) ;
		
				$ordenFoto = $this->impactarImagen($id_inmobiliaria ,$id_aviso, 'imagen5' , $ordenFoto) ;
		
			}
			else
				echo "aviso sin imagenes"; /*grabar foto por defecto*/
		
		}
		catch(Exception $e)
		{ 
			
			if (!is_null($dir) )
			{
				if (file_exists($dir))
				{
					$files = array_diff(scandir($dir), array('.','..')); 
					foreach ($files as $file) 
					{ 
						(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
					}
					rmdir($dir); 
				}
			}
			$this->db->rollback();
	
			$var = $e->getMessage();
			echo $var ; 
		}


		//$this->view->showSuccess("user.php","Las fotos se han cargado exitosamente.") ;
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
		 $perfilUsuario = $userPerfil->getUserProfile($_SESSION['IdUser']) ;  //(4 /*id_usuario*/);
		 $provincias = $userPerfil->listadoProvincias() ;
		 $dataPerfil['provincias'] =$provincias ;
		 $dataPerfil['perfilUsuario'] = $perfilUsuario  ;
		
		$this->view->showDetail("userProfile.php" ,$dataPerfil)  ;
		Echo "<pre>"; 
		print_R($dataPerfil) ;		

	}
	
	public function getAvisos()
	{
		 require_once 'models/UserModel.php';
         $userAvisos = new UserModel();
		 $avisos = $userAvisos->getAvisosCustomer($_SESSION['IdUser'] , 20, 0) ;
		 $dataavisos['salidaCentral'] = $avisos ;
		 $this->view->showDetail("user.php" , $dataavisos ) ;
	}
	function resizeImagen($ruta, $nombre, $alto, $ancho,$nombreN,$extension)
	{
		
		$rutaImagenOriginal = $ruta.$nombre;
		
		if($extension == 'GIF' || $extension == 'gif'){
		$img_original = imagecreatefromgif($rutaImagenOriginal);
		}
		if($extension == 'jpg' || $extension == 'JPG'){
		
		$img_original = imagecreatefromjpeg($rutaImagenOriginal);
		
		}
		if($extension == 'png' || $extension == 'PNG'){
		$img_original = imagecreatefrompng($rutaImagenOriginal);
		}
		
		$max_ancho = $ancho;
		$max_alto = $alto;
		list($ancho,$alto)=getimagesize($rutaImagenOriginal);
		$x_ratio = $max_ancho / $ancho;
		$y_ratio = $max_alto / $alto;
		if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho 
		$ancho_final = $ancho;
			$alto_final = $alto;
		} elseif (($x_ratio * $alto) < $max_alto){
			$alto_final = ceil($x_ratio * $alto);
			$ancho_final = $max_ancho;
		} else{
			$ancho_final = ceil($y_ratio * $ancho);
			$alto_final = $max_alto;
		}
		
		$tmp=imagecreatetruecolor($ancho_final,$alto_final);
		imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
		imagedestroy($img_original);
		$calidad=90;
		
		
		if($extension == 'GIF' || $extension == 'gif'){
		 imagegif($tmp,$ruta.$nombreN,$calidad);
		}
		if($extension == 'jpg' || $extension == 'JPG'){
		 imagejpeg($tmp,$ruta.$nombreN,$calidad);
		}
		if($extension == 'png' || $extension == 'PNG'){
		 imagepng($tmp,$ruta.$nombreN,$calidad);
		}   
		
		
	}
}
?>