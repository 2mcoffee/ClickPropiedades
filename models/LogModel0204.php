<?php
class LogModel
{
    protected $db;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }
	public function fotosAviso()
    {
        $idAviso = $this->getWhere() ;
        $sql_fa = 'select url , orden  from fotos  where id_aviso =' .$idAviso.' order by  orden' ; 
        $fotos  = $this->db->prepare($sql_fa) ;
        $fotos->execute() ;
        return $fotos;
    }
	public function getAvisosCustomer($id_usuario , $limit , $offset)
	{
		$sql_user= "select 	
		avi.id_aviso as idAviso ,
		inmo.nombre as NombreInmobiliaria , 
		inmo.url_log as fotoInmobiliaria , 
		( CASE when  destaca.id_aviso is null then 0 else 1 end  )as destacado ,
		 tipo_oper.descripcion  as operacion ,
		 tipo_inmu.descripcion as inmueble ,
		 pro.descripcion as provincia ,
		 loca.descripcion as localidad ,
		 tipo_mone.descripcion as moneda ,
		 db.precio as precio ,
		 domiAvi.calle as calleAviso,
		 domiAvi.altura as alturaAviso,
		 domiAvi.piso as pisoAviso ,
		 domiInmo.calle as calleInmo,
		 domiInmo.altura as alturaInmo,
		 domiInmo.piso as pisoInmo ,
		 (select url from fotos where id_aviso = avi.id_aviso and orden=1) as fotoInmueble ,
		 avi.descripcion as descripcion ,
		 cara.terraza as terraza, 
		 cara.luminosidad  as luminosidad , 
		 cara.seguridad as seguridad , 
		 cara.sup_total as sup_total , 
		 cara.sup_cubierta as sup_cubierta,
		 cara.banos as banos ,
		 cara.toilette as toilette ,
		 cara.garage as garage , 
		 cara.balcon as balcon ,
		 cara.patio as patio , 
		 cara.jardin as jardin , 
		 cara.pileta as pileta
		 FROM  avisos avi  INNER JOIN  inmobiliarias inmo ON inmo.id_inmobiliaria = avi.id_inmobiliaria 
		 /* INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
		 INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
		 INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
		 INNER JOIN partidos par ON par.id_partido = loca.id_localidad
		 INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
		 INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
		 inner join tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
		 inner join tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
		 inner join domicilios domiAvi on domiAvi.id_domicilio = avi.id_domicilio
		 inner join domicilios domiInmo on domiInmo.id_domicilio = inmo.id_domicilio
		 inner join estado_aviso ea on ea.id_estadoAviso = avi.id_estadoAviso */
		 
		  LEFT JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
		 LEFT JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
		 LEFT JOIN localidades loca on avi.id_localidad = loca.id_localidad
		 LEFT JOIN partidos par ON par.id_partido = loca.id_localidad
		 LEFT JOIN provincias pro ON pro.id_provincia = par.id_provincia
		 LEFT JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
		 LEFT join tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
		 LEFT join tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
		 LEFT join domicilios domiAvi on domiAvi.id_domicilio = avi.id_domicilio
		 LEFT join domicilios domiInmo on domiInmo.id_domicilio = inmo.id_domicilio
		 LEFT join estado_aviso ea on ea.id_estadoAviso = avi.id_estadoAviso
		 LEFT JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
		 
		 where inmo.id_usuario = " .$id_usuario ." order by avi.id_aviso limit " .$limit ."  offset " .$offset. "  ";
		 
		$customer = $this->db->prepare($sql_user) ;
        $customer->execute()  ;
		
		return $customer ; 
	}
	
	public function clienteValido($usuario , $pwd)
	{
		$sql_acc = "SELECT usuario FROM usuarios  where usuario= '".$usuario . "' and pwd ='" .$pwd ."'"  ; 
		 
	
		$acceso = $this->db->prepare($sql_acc) ;
		$acceso -> execute () ;
		$existe = $acceso->rowCount();

		
		if($existe == 0 )
		 return 404 ;
		else
		 return 100;
	}
	public function getClienteRol($usuario , $pwd)
	{
		$sql_cr ="select u.usuario as usuario, r.rol  as rol , u.id_usuario from usuarios u inner join roles r on u.id_rol = r.id_rol where usuario ='" .$usuario ."' and pwd='" .$pwd."'"     ;
		
		
		
		$cliente = $this->db->prepare($sql_cr);
		$cliente->execute();
		return $cliente ;
	}
	public function enableCustomer($usuario , $pwd)
	{
		$sql_ec = "select u.id_usuario from usuarios u INNER JOIN inmobiliarias i on u.id_usuario = i.id_usuario where u.usuario ='" .$usuario ."' and u.pwd='" .$pwd. "'  and i.habilitada= 1" ; 
		
	
		
		$enable = $this->db->prepare($sql_ec);
		$enable->execute() ;
		return $enable->rowCount() ;
	}
	public function checkUser($usuario)
	{
		$sql_chk = "select usuario from usuarios where usuario ='" .$usuario. "'"	 ;
		$check  = $this->db->prepare($sql_chk) ;
        $check->execute() ;
		$live = $check->rowCount () ;
		return $live ;
	}
	public function listadoProvincias()
	{
		$consulta = $this->db->prepare('select id_provincia, descripcion from provincias');
	    $consulta->execute();
        return $consulta;
	}
	public function InsertCustomer($username, $password, $razonsocial, $cuit, $asesor, $region, $telefono, $movil,  $email, $web, $direccion, $altura, $piso, $depto , $localidad, $alto, $ancho, $id_rol, $habilitada, $tipo_plan)
	{
		$dir = null ;
	
		try
		{
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			
			$sql_user = "INSERT INTO usuarios (usuario,pwd,id_rol) values (:usuario, :pwd, :id_rol) " ;
			$stm_insert_user = $this->db->prepare($sql_user);
			$stm_insert_user->bindParam(':usuario' , $username ,PDO::PARAM_STR );
			$stm_insert_user->bindParam(':pwd' , $password , PDO::PARAM_STR );
			$stm_insert_user->bindParam(':id_rol' , $id_rol , PDO::PARAM_INT );
			$stm_insert_user->execute() ;
		
			$last_id_user = $this->db->lastInsertId();
			
			$sql_dom = "INSERT INTO domicilios (calle,altura,piso, depto ) values 	(:calle, :altura,:piso , :depto )" ;
			$stm_insert_dom = $this->db->prepare($sql_dom);
			$stm_insert_dom->bindParam(':calle' , $direccion , PDO::PARAM_STR) ;
			$stm_insert_dom->bindParam(':altura' , $altura , PDO::PARAM_STR) ;
			$stm_insert_dom->bindParam(':piso' , $piso , PDO::PARAM_STR) ;
			$stm_insert_dom->bindParam(':depto' , $depto , PDO::PARAM_STR) ;
			$stm_insert_dom->execute() ;
			$last_id_dom = $this->db->lastInsertId();
			$fecha_alta=date("Y-m-d H:i:s:m");
		
			//$sql_inmo="INSERT INTO inmobiliarias (nombre, cuit, url_log , habilitada , id_tipo_plan , id_domicilio, fecha_alta, id_usuario, fecha_alta_plan , url, contacto ) 
			//	  values (:nombre, :cuit , :url_log , :habilitada , :id_tipo_plan , :id_domicilio, :fecha_alta, :id_usuario, :fecha_alta_plan , :url, :contacto ) " ; 
			$sql_inmo="INSERT INTO inmobiliarias (nombre, cuit,  habilitada , id_tipo_plan , id_domicilio, fecha_alta, id_usuario, fecha_alta_plan , url, contacto , id_localidad ) 
					values (:nombre, :cuit  , :habilitada , :id_tipo_plan , :id_domicilio, :fecha_alta, :id_usuario, :fecha_alta_plan , :url, :contacto , :id_localidad ) " ; 		
					
			//$logo= $last_id_user.$fecha_alta.$_FILES['logo']['name'] ;

			$stm_insert_inmo = $this->db->prepare($sql_inmo);
			$stm_insert_inmo->bindParam(':nombre' , $razonsocial ,  PDO::PARAM_STR ) ;
			$stm_insert_inmo->bindParam(':cuit' , $cuit ,  PDO::PARAM_STR ) ;
			//$stm_insert_inmo->bindParam(':url_log' , $nNombre ,  PDO::PARAM_STR ) ; 
			$stm_insert_inmo->bindParam(':habilitada' , $habilitada ,  PDO::PARAM_INT ) ; 
			$stm_insert_inmo->bindParam(':id_tipo_plan' , $tipo_plan ,  PDO::PARAM_INT ) ; 
			$stm_insert_inmo->bindParam(':id_domicilio' , $last_id_dom,  PDO::PARAM_STR ) ; 
			$stm_insert_inmo->bindParam(':fecha_alta' , $fecha_alta,  PDO::PARAM_STR ) ; 
			$stm_insert_inmo->bindParam(':id_usuario' , $last_id_user ,  PDO::PARAM_STR ) ; 
			$stm_insert_inmo->bindParam(':fecha_alta_plan' , $fecha_alta ,  PDO::PARAM_STR ) ; 
			$stm_insert_inmo->bindParam(':url' , $web ,  PDO::PARAM_STR ) ; 
			$stm_insert_inmo->bindParam(':contacto' , $asesor ,  PDO::PARAM_STR ) ; 
			$stm_insert_inmo->bindParam(':id_localidad' , $localidad ,  PDO::PARAM_STR ) ; 
			$stm_insert_inmo->execute() ; 
		
			$last_id_inmo = $this->db->lastInsertId();
			$dir = 'uploads/'.$last_id_inmo ;
			
			if (!empty($_FILES['logo']['name']) )
			{
				if (!file_exists($dir))
				{
					$timestamp  = date('Ymdhis'.substr((string)microtime(), 1, 8));  // date("YMDhism" );
					$ext = explode(".",$_FILES['logo']['name']) ;
					$extension  = end($ext) ;
					$lenExten = strlen($extension)  + 1 ;
					$nNombre = substr($_FILES['logo']['name'] , 0, -$lenExten) ;
					$nNombre = $nNombre.$last_id_inmo.$timestamp.".".$extension ;
					$dirmake = mkdir( $dir, 0777) ;
					$target_path = $dir .'/';
					$ruta = $dir .'/';
					$target_path = $target_path . basename( $_FILES['logo']['name']);
					
					
					
					
					if(move_uploaded_file($_FILES['logo']['tmp_name'], $target_path)) 
					{ 
						$this->resizeImagen($ruta, $_FILES['logo']['name'], $alto, $ancho,$nNombre,$extension) ;
						unlink($dir."/".$_FILES['logo']['name'] ) ;
						$sql_upLogo= "update inmobiliarias set url_log = ? where id_inmobiliaria = ? " ;
						$uplogo = $this->db->prepare($sql_upLogo);
						$uplogo->execute(array($nNombre,$last_id_inmo));
					} 
				}
			}

			$sql_mail ="INSERT INTO mails (mail, id_inmobiliaria ) values (:mail, :id_inmobiliaria)" ;
			$stm_insert_mail = $this->db->prepare($sql_mail);
			$stm_insert_mail->bindParam(':mail', $email,PDO::PARAM_STR) ;
			$stm_insert_mail->bindParam(':id_inmobiliaria', $last_id_inmo ,PDO::PARAM_STR) ;
			$stm_insert_mail->execute() ;
		
			
			
			$sql_tel ="INSERT INTO telefonos (numero, region , movil, id_inmobiliaria) values(:numero, :region , :movil, :id_inmobiliaria) " ;
			$stm_insert_tel = $this->db->prepare($sql_tel);
			$stm_insert_tel->bindParam(':numero', $telefono ,PDO::PARAM_STR) ;
			$stm_insert_tel->bindParam(':region', $region ,PDO::PARAM_STR) ;
			$stm_insert_tel->bindParam(':movil', $movil ,PDO::PARAM_STR) ;
			$stm_insert_tel->bindParam(':id_inmobiliaria', $last_id_inmo ,PDO::PARAM_STR) ;
			$stm_insert_tel->execute();

			$this->db->commit();		
			return;
		}
		//catch(PDOException $e) 
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
	
			return $e->getMessage();
		}
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
	
	
	public function getPassword ($usuario, $mail)
	{
		$sql_getPass = " select u.usuario ,  u.pwd  , m.mail  from usuarios u INNER JOIN inmobiliarias i on u.id_usuario = i.id_usuario 
						 inner join mails m on m.id_inmobiliaria = i.id_inmobiliaria where u.usuario ='" .$usuario."' and m.mail = '" .$mail. "'" ;
		$cleanpwd = $this->db->prepare($sql_getPass) ;
		$cleanpwd->execute() ;
		return $cleanpwd ; 
	}
	

}
?> 