<?php
ini_set('display_errors', 0 ); // set to 0 when not debugging
ini_set('gd.jpeg_ignore_warning', 1); 
ini_set('memory_limit', '128M') ;
date_default_timezone_set('America/Argentina/Buenos_Aires');

error_reporting(E_ALL);

class UserController
{
    function __construct()
    {
	   $this->view = new View();

		IF(empty($_SESSION['User']) )
		{
			session_destroy();
			$this->view->showInvalido("login.php","Inicie sesión con su usuario y clave.");
			exit ; 
		}
		else
		{
			if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 10000)) 
			{
				session_unset();
				session_destroy();	
				$this->view->showInvalido("login.php" , "La sesión ha finalizado. Vuelva a ingresar al sistema.");
				exit ;
			}	
			else
				$_SESSION['LAST_ACTIVITY']	 = time() ;
		}
	   
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
		
		$cantidadAvisosPlan = $UserMo->avisosHabilitados($_SESSION['IdUser']) ;
		$cantidadAvisosCargados = $UserMo->avisosCargados($_SESSION['IdUser']) ;
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
			$this->view->showInvalido("success.php", "Ha superado la cantidad de avisos cargados que tiene permitido. Pongase en contacto con ClickPropiedades");
				
		}	
	}
	
	public function altaAviso()
	{
		require 'models/UserModel.php';
        $user = new UserModel();

		/*$_POST['$id_inmobiliaria'] , ?? IDENTIFICAR LA SESSION? O DE ALGUNA FORMA*/
		/*$_POST['$id_caracteristica'] , $_POST['$id_dato_basico'] , $_POST['$id_domicilio'] , CORROBORAR MANERA DE INSERTAR*/ 

		/*   Echo "<pre>"; 
print_R($_POST) ;
print_R($_FILES);  */
		
		$id_inmobiliaria = $user->getIdInmobiliaria($_SESSION['IdUser'] ) ;
		$idAviso =  $user->insertAviso($_POST['tipoinmueble'], $_POST['operacion'] , $_POST['moneda'] , $_POST['precio']  , $_POST['ambientes'], $_POST['dormitorios'], $_POST['antiguedad'], $_POST['estado'], $_POST['profesional'], $_POST['terraza'], $_POST['luminosidad'], $_POST['seguridad'] , $_POST['suptotal'], $_POST['supcubierta'], $_POST['banos'], $_POST['toilette'] , $_POST['garage'] , $_POST['balcon'], $_POST['patio'], $_POST['jardin'], $_POST['pileta'] , $_POST['calle'], $_POST['altura'] , $_POST['piso']  ,  $_POST['depto'] , $id_inmobiliaria , $_POST['ficha'] ,  $_POST['localidad']  , $_POST['descripcion'] , date("Y-m-d H:i:s:m")  , 1 /*$_POST['$id_estadoAviso']*/ ) ;
		
		if (is_null($idAviso) or is_string($idAviso) ) /*hubo un error*/
		{
			/* echo "entre por dopnde no debia" ;
			$this->view->showInvalido("user.php", $idAviso ) ; */
			
			
			$this->altaFotos($id_inmobiliaria, $idAviso) ; 
			$this->view->showSuccess("success.php", "El aviso ha sido cargado con exito.") ; 
		}
		else
		{
			echo "else" ; 
			$this->altaFotos($idAviso) ; 
			$this->view->showSuccess("insertPicture.php","Se cargo un nuevo aviso correctamente!!" ) ; 
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
			$dirmake = mkdir($dir, 0777 , true) ;

		
		return $dir;
	}
	private function crearDirectorioInmobiliaria($id_inmobiliaria )
	{
		$dir = 'uploads/'.$id_inmobiliaria ;
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
			$alto= 450 ;
			$ancho= 487 ;
		
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
	public function updateImagen($id_aviso , $nombreImagen , $pathFoto )
	{
		$alto= 450 ;
		$ancho= 487 ;
		$extension = $this->obtenerExtension($_FILES[$nombreImagen]['name'] ) ;
		$nuevoNombreImagen = $this->obtenerNombre($_FILES[$nombreImagen]['name'] , $extension , $id_aviso )  ;
		if(move_uploaded_file($_FILES[$nombreImagen]['tmp_name'],  $pathFoto.'/'.$_FILES[$nombreImagen]['name']  )) 
		{
				$this->resizeImagen($pathFoto."/", $_FILES[$nombreImagen]['name'], $alto, $ancho,$nuevoNombreImagen,$extension) ;
				unlink($pathFoto."/".$_FILES[$nombreImagen]['name'] ) ;
		}
		return $nuevoNombreImagen;
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
/* 			else
				echo "aviso sin imagenes";  */
		
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
  

		$id_inmobiliaria   = $userModel->getIdInmobiliaria($_SESSION['IdUser'] ) ;
		$foto = $userModel->updateProfile( $_SESSION['IdUser'] ,$_POST['razonsocial'] ,$_POST['cuit'] ,$_POST['asesor'] ,$_POST['codigo'] ,$_POST['telefono'] ,$_POST['email'] ,$_POST['web'] ,$_POST['calle'],$_POST['altura'] ,$_POST['piso']  , $_POST['piso'] ,$_POST['depto']  ,   $_POST['localidad'],  $id_inmobiliaria) ;
		
	
		
		if($this->updateFoto($foto, 'logo') )
		{
			$path  = 'uploads/'.$id_inmobiliaria ;
			if(! file_exists($path))
				$this->crearDirectorioInmobiliaria($id_inmobiliaria) ;
				
			$nuevaFoto = $this->updateImagen(1 , 'logo' , $path ) ;
			$userModel->updateFoto($nuevaFoto , $id_inmobiliaria ) ;
			if (file_exists($path."/".$foto ))
				unlink($path."/".$foto ) ;
		}
		
		
		
		$this->view->showSuccess("success.php", "Se ha actualizado el perfil de usuario" ) ; 
		
	}
	public function updateAviso()
	{
		require 'models/UserModel.php';
        $userupdate = new UserModel();
		/*
				  Echo "<pre>"; 
print_R($_POST) ;
	print_R($_FILES);  */

		$ok = $userupdate->updateAviso($_POST['idAviso'] , $_POST['tipoinmueble'] , $_POST['ficha'] , $_POST['operacion'] , $_POST['moneda'] , $_POST['precio'] , $_POST['provincia']  , $_POST['partido'] , $_POST['localidad']  , $_POST['calle'] , $_POST['altura'] , $_POST['piso'] , $_POST['depto'] , $_POST['suptotal'], $_POST['supcubierta'] , $_POST['ambientes'] , $_POST['dormitorios'] , $_POST['banos'] , $_POST['toilette'] , $_POST['antiguedad'] , $_POST['estado'] , $_POST['luminosidad'] , $_POST['terraza'] , $_POST['balcon'] , $_POST['patio'] , $_POST['pileta'] , $_POST['jardin'] , $_POST['garage'] , $_POST['seguridad']  , $_POST['profesional'] , $_POST['descripcion'] ) ;
		if(! empty($_FILES['imagen1']['name'] ))	
			$this->updateFotoAviso($userupdate, $_POST['idInmobiliaria'] ,$_POST['idAviso'] , 'imagen1'  , 1 ) ;
		
		if(! empty($_FILES['imagen2']['name'] ))	
			$this->updateFotoAviso($userupdate, $_POST['idInmobiliaria'] ,$_POST['idAviso'] , 'imagen2'  , 2 ) ;
			
		if(! empty($_FILES['imagen3']['name'] ))	
			$this->updateFotoAviso($userupdate, $_POST['idInmobiliaria'] ,$_POST['idAviso'] , 'imagen3'  , 3 ) ;			
		
		if(! empty($_FILES['imagen4']['name'] ))	
			$this->updateFotoAviso($userupdate, $_POST['idInmobiliaria'] ,$_POST['idAviso'] , 'imagen4'  , 4 ) ;		
			
		if(! empty($_FILES['imagen5']['name'] ))	
			$this->updateFotoAviso($userupdate, $_POST['idInmobiliaria'] ,$_POST['idAviso'] , 'imagen5'  , 5 ) ;
			
		if ($ok =="OK") 
		
			$this->view->showSuccess("success.php","El aviso se ha actualizado exitosamente") ; 
		else
			$this->view->showInvalido("success.php","Ha ocurrido un error al actualizar el aviso. ".$ok  ) ; 
	}
	private function updateFotoAviso($Model , $idInmobiliaria , $idAviso , $nombreImagen , $orden)
	{

		$path  = 'uploads/'.$idInmobiliaria.'/'.$idAviso  ;
		
		$this->crearDirectorio($idInmobiliaria ,$idAviso ) ;
		
		$foto = $Model->getFotoAviso($idAviso, $orden);

		$nuevaFoto = $this->updateImagen($idAviso , $nombreImagen , $path ) ;
		

		if (! empty($foto) )
		{
			
			if (file_exists($path."/".$foto ))
			{
				unlink($path."/".$foto ) ;
				$resutl = $Model->updateFotoAviso($nuevaFoto, $idAviso , $orden ) ;
			}
			else
				$resutl = $Model->updateFotoAviso($nuevaFoto, $idAviso , $orden ) ;
			
		}
		else
			$Model->insertFotos($nuevaFoto, $idAviso , $orden) ;
		
		

		

	}
	
	private function updateFoto($foto,$nombreFiles)
	{
		if ($foto == $_FILES[$nombreFiles]['name'] || empty($_FILES[$nombreFiles]['name'] ) )
			return false ;
		else
			return  true ;
		
	}
	public function getPerfilUsuario()
	{
	
		 require 'models/UserModel.php';
         $userPerfil = new UserModel();
		 $perfilUsuario = $userPerfil->getUserProfile($_SESSION['IdUser']) ;  //(4 /*id_usuario*/);
		 $provincias = $userPerfil->listadoProvincias() ;
		 $dataPerfil['provincias'] =$provincias ;
		 $dataPerfil['perfilUsuario'] = $perfilUsuario  ;
		 	
		$this->view->showPerfilUsuario("userProfile.php" ,$dataPerfil)  ;
/* 		Echo "<pre>"; 
		print_R($dataPerfil) ;	 */	

	}
	
	public function getAvisos()
	{
		 require_once 'models/UserModel.php';
         $userAvisos = new UserModel();
		 
		 if (isset($_GET['page'])) 
		{ 
			$page = $_GET['page']; 
		} else { $page=1; }; 
		
		$start_from = ($page - 1) * 20;

		
		 $avisos = $userAvisos->getAvisosCustomer($_SESSION['IdUser'] ,  20 , $start_from    ) ;
		 
		 $avisoExtra = $userAvisos->getDataCustomer($_SESSION['IdUser']) ;
		 
		 $totalMisAvisos = $userAvisos->totalMisAvisos($_SESSION['IdUser']) ;
		 
		 $dataavisos['salidaCentral'] = $avisos ;
		 $dataavisos['salidaInfoRol'] =	$avisoExtra ;
		 $dataavisos['salidaTotalRegistros'] =	$totalMisAvisos ;
/* 		 $array = array("totalRegistros" => '50') ;
		 $dataavisos['salidaTotalRegistros'] = $array ; */
		 
		 
		 $this->view->showDetail("user.php" , $dataavisos ) ;

		 		 
	}
	public function getAvisotoEdit ()
	{
 		require_once 'models/UserModel.php';
        $userAE = new UserModel();
		

		$aviso  = $userAE->getAvisotoEdit($_GET['destino']) ;
		$provincias = $userAE->listadoProvincias() ;
		$edificaciones = $userAE->listadoEdificaciones();
		$operaciones = $userAE->listadoOperaciones();
		$monedas  = $userAE->listadoMonedas() ;
		$fotos  = $userAE->fotosAviso($_GET['destino']) ;

		
		$dataAvisotoEdit['salidaAviso'] = $aviso ;
		$dataAvisotoEdit['provincias'] = $provincias ;
		$dataAvisotoEdit['edificaciones'] = $edificaciones ; 
		$dataAvisotoEdit['operaciones'] = $operaciones; 
		$dataAvisotoEdit['monedas'] = $monedas; 
		$dataAvisotoEdit['fotosAviso'] = $fotos; 
		
		$this->view->showAvisotoEdit("updateAd.php",$dataAvisotoEdit ) ;
	}
	
	public function borrarAviso()
	{
		require_once 'models/UserModel.php';
        $userdelete = new UserModel();
		
	 	$ok = $userdelete->deleteAviso($_GET['destino']) ;
		if($ok == "OK")
		{
			try
			{
				$this->eliminarImagen($_GET['pertenece'] , $_GET['destino']) ;
				$this->view->showSuccess("success.php", "El aviso se ha borrado correctamente."  ) ; 
			}
			catch(Exception $e)
			{ 
				$this->view->showSuccess("success.php", "Ha ocurrido un error al eliminar las fotos del aviso" .$e ) ; 
			}
		}
		else
			$this->view->showSuccess("success.php", "Ha ocurrido un error al eliminar el aviso" .$ok ) ; 
	 
		
	}
	public function eliminarImagen($idInmobiliaria , $idAviso)
	{
		$dir = 'uploads/'.$idInmobiliaria .'/'.$idAviso ;
		
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
	public function reservarAviso() 
	{
		require_once 'models/UserModel.php';
        $userReservar = new UserModel();
		
		$idEstado = 3 ;/*es RESERVADO*/
		
		$ok = $userReservar->resevarAviso($_GET['destino'] , $idEstado  ) ;
		if ($ok == "OK")
			$this->view->showSuccess("success.php", "El aviso fue marcado como reservado ."  ) ; 
		else	
			$this->view->showSuccess("success.php", "Ha sucedio un error al intentar reservar el aviso.  "  ) ; 
		
	}
	function resizeImagen($ruta, $nombre, $alto, $ancho,$nombreN,$extension)
	{
		
		$rutaImagenOriginal = $ruta.$nombre;
		
		if($extension == 'GIF' || $extension == 'gif'){
		$img_original = imagecreatefromgif($rutaImagenOriginal);
		}
		if($extension == 'jpg' || $extension == 'JPG' || $extension == 'jpeg' || $extension == 'JPEG' ){
		
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
		if($extension == 'jpg' || $extension == 'JPG' || $extension == 'jpeg' || $extension == 'JPEG' ){
		 imagejpeg($tmp,$ruta.$nombreN,$calidad);
		}
		if($extension == 'png' || $extension == 'PNG'){
		 imagepng($tmp,$ruta.$nombreN,$calidad);
		}   
		
		
	}
}
?>