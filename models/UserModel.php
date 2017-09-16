<?php
class UserModel
{
    protected $db;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }
	public function listadoMonedas()
	{
		$monedas = $this->db->prepare('select id_tipo_moneda as id_moneda, descripcion as moneda from tipo_monedas ') ;
		$monedas -> execute() ;
		return $monedas ;
		
	}
	public function listadoOperaciones()
	{
		$operaciones = $this->db->prepare('select id_tipo_operacion as id_operacion ,descripcion  as operacion from tipo_operaciones ' ) ;
		$operaciones -> execute();
        return $operaciones;
	}
	public function listadoProvincias()
	{
		$consulta = $this->db->prepare('select id_provincia, descripcion from provincias');
	    $consulta->execute();
        return $consulta;
	}
	public function listadoEdificaciones()
	{
		$edificaciones = $this->db->prepare('select id_tipo_inmueble as id_edificacion , descripcion as edificacion from tipo_inmuebles order by orden ' ) ;
		$edificaciones -> execute();
        return $edificaciones ;
	}
	public function avisosHabilitados($idUsuario)
	{
		$sqlha ="select cantidad_inmueble as limiteInmuebles from inmobiliarias inmo inner join tipo_plan_inmobiliarias tipo on inmo.id_tipo_plan = tipo.id_tipo_plan  where inmo.id_usuario = " .$idUsuario ; 

		$habilitados = $this->db->prepare($sqlha) ;
		$habilitados->execute() ;
		$inmuebles = $habilitados->fetch() ;
		return $inmuebles['limiteInmuebles'] ;
	}
	public function totalMisAvisos($idUsuario)
	{
		$sqlma ="select count(*) as totalRegistros  
		 FROM  avisos avi  INNER JOIN  inmobiliarias inmo ON inmo.id_inmobiliaria = avi.id_inmobiliaria 
		 INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
		 INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
		 INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
		 INNER JOIN partidos par ON par.id_partido = loca.id_partido
		 INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
		 INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
		 inner join tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
		 inner join tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
		 left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
		 WHERE inmo.habilitada = 1 and inmo.id_usuario = " .$idUsuario ; 
		
		$misAvisos = $this->db->prepare($sqlma) ;
		$misAvisos->execute() ;
/* 		$total = $misAvisos->fetch() ;
		return $total['totalRegistros'] ; */
		return $misAvisos ; 
	}
	public function avisosCargados($idUsuario)
	{
		$sqlac ="select inmo.id_inmobiliaria  from inmobiliarias inmo inner join avisos avi on inmo.id_inmobiliaria = avi.id_inmobiliaria where inmo.id_usuario = " .$idUsuario ;
		$cargados = $this->db->prepare($sqlac) ;
		$cargados->execute() ;
		return $cargados->rowCount() ; 
	}
	public function getAvisosCustomer($id_usuario , $limit , $offset)
	{
		$sql_user= "select 	
		avi.id_aviso as idAviso ,
		inmo.id_inmobiliaria as idInmobiliaria,
		inmo.nombre as NombreInmobiliaria , 
		inmo.url_log as fotoInmobiliaria , 
		( CASE when  destaca.id_aviso is null then 0 else 1 end  )as destacado ,
		( CASE when  avi.id_estadoAviso = 3 then 1 else 0 end  )as reservado  ,
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
/* 		  INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
		 INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
		 INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
		 INNER JOIN partidos par ON par.id_partido = loca.id_localidad
		 INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
		 INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
		 inner join tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
		 inner join tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
		 inner join domicilios domiAvi on domiAvi.id_domicilio = avi.id_domicilio
		 inner join domicilios domiInmo on domiInmo.id_domicilio = inmo.id_domicilio
		 inner join estado_aviso ea on ea.id_estadoAviso = avi.id_estadoAviso  */
		 
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
		 where inmo.id_usuario = " .$id_usuario ." order by avi.id_aviso limit " .$limit ." offset " .$offset." ";

		
		$customer = $this->db->prepare($sql_user) ;
        $customer->execute()  ;
		
		return $customer ; 
	}
	
	public function resevarAviso($idAviso , $idEstado) 
	{
		try
		{
		
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			
			$sqlr ="update avisos set id_estadoAviso = ? where id_aviso = ?" ;
			$reserv = $this->db->prepare($sqlr);
			$reserv->execute(array($idEstado , $idAviso ));
	
			$this->db->commit();	
			
		return "OK"; 
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			echo $e->getMessage();
		}
	
	}
	public function updateProfile($idUsuario ,  $nombreInmobiliaria,  $cuit , $contacto ,$codigoArea , $telefono , $email , $site ,$calle, $altura,$piso , $piso ,$depto  ,$id_localidad  /*id_localidad*/, &$id_inmobiliaria ) 
	{
	
		try
		{
		
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			
/* 			$sql_upUser = "update usuarios set usuario = ? , pwd = ?  where id_usuario = ? " ;
			$upUser = $this->db->prepare($sql_upUser) ;
			$upUser->execute (array ( $usuario , $pwd , $idUsuario ) ) ; */
		
			$sql_upInmo = "update inmobiliarias set nombre = ? , cuit = ? , url = ?,  contacto = ?   , id_localidad = ? where id_usuario = ? " ;
			$upInmo = $this->db->prepare($sql_upInmo);
			$upInmo->execute(array($nombreInmobiliaria,$cuit , $site , $contacto , $id_localidad , $idUsuario ));
			
			
			$sql_up = 'select id_inmobiliaria , id_domicilio ,url_log from inmobiliarias where id_usuario =  :id_usuario' ;
			$stm_p = $this->db->prepare($sql_up) ;
			$stm_p -> execute(array(':id_usuario' => $idUsuario  ) ) ;
			$phppro = $stm_p->fetch(PDO::FETCH_ASSOC);
			
			$qry_id_inmobiliaria = $phppro['id_inmobiliaria'] ;
			$qry_id_domicilio = $phppro['id_domicilio'] ;
			$qry_foto = $phppro['url_log'] ;
			
/* 			echo " inmobiliaria ";echo $qry_id_inmobiliaria ;
			echo " domiciliaria ";echo $qry_id_domicilio;				
			echo "mi id domi : " ; echo $qry_id_domicilio ; */
			
			
			$sql_upDomi = "update domicilios set calle = ? , altura = ? , piso = ? , depto = ? where id_domicilio = ? "  ;
			$upDomi = $this->db->prepare($sql_upDomi);
			$upDomi->execute(array($calle, $altura,$piso  ,$depto  , $qry_id_domicilio	));
			
			$sql_mail = "update mails set mail = ? where id_inmobiliaria = ? " ;
			$upMail = $this->db->prepare($sql_mail);
			$upMail->execute(array($email , $qry_id_inmobiliaria ));
			
			$movil = null ;
			$sql_upTel ="update telefonos set numero = ? , region = ? , movil = ? where id_inmobiliaria = ? " ;
			$upTel = $this->db->prepare($sql_upTel);
			$upTel->execute(array($telefono  , $codigoArea ,  $movil , $qry_id_inmobiliaria ));
			
			

			$id_inmobiliaria = $qry_id_inmobiliaria ; 
			$this->db->commit();	
			
			return $qry_foto; 
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			echo $e->getMessage();
		}
		
		
		
		
	/* 	$sql_upLogo = "update domicilios set calle = ? , altura = ? ,  piso = ? , depto = ? where id_domicilio = ?" ;
		$updom = $this->db->prepare($sql_upLogo) ;
		$updom->execute(array() ) ;
		
		$sql_upLogo = "update mails set mail = ?  where id_mail = ? ";
		$upmail = $this->db->prepare($sql_upLogo) ;
		$upmail->execute(array() ) ; 

		$sql_upLogo = "update telefonos set numero = ? , region = ? , movil = ? where id_telefono = ? ";
		$uptele = $this->db->prepare($sql_upLogo) ; 
		$uptele->execute(array() ) ; */
		
		/*agregar el update de foto si corresponde*/
		
	}
	public function updateAviso($idAviso, $tipoinmueble , $ficha , $operacion , $moneda , $precio , $provincia , $partido , $localidad , $calle , $altura , $piso , $depto , $suptotal , $supcubierta , $ambientes , $dormitorios , $banos , $toilette , $antiguedad , $estado , $luminosidad , $terraza , $balcon, $patio , $pileta , $jardin , $garage, $seguridad , $profesional , $descripcion )
	{
		try
		{
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			$sqlAviso = "select id_caracteristica , id_dato_basico , id_domicilio  from avisos where id_aviso = :id_aviso" ;
			$stm_aviso = $this->db->prepare($sqlAviso) ;
			$stm_aviso ->execute(array(':id_aviso' => $idAviso  ) ) ;
			$phpAviso = $stm_aviso->fetch(PDO::FETCH_ASSOC);
			
			$id_caracteristica  = $phpAviso['id_caracteristica'] ;
			$id_dato_basico  = $phpAviso['id_dato_basico'] ;
			$id_domicilio = $phpAviso['id_domicilio'] ;
			
			$sqlDB = "update datos_basicos set id_tipo_inmueble = ? , id_tipo_operacion = ? , id_tipo_moneda = ? , precio = ? where id_dato_basico = ? " ;
			$upDB = $this->db->prepare($sqlDB) ; 
			$upDB->execute(array($tipoinmueble , $operacion , $moneda , $precio , $id_dato_basico ) ) ;

			
			$sqlCara = "update caracteristicas set can_ambientes = ? , can_dormitorios = ? , antiguedad = ? , disposicion = ? , profesional = ? , terraza = ? , luminosidad = ? , seguridad = ? , sup_total = ? , sup_cubierta = ? , banos = ? , toilette = ? , garage = ? , balcon = ? , patio = ? , jardin = ? , pileta = ? where id_caracteristica = ? ";
			$upCara = $this->db->prepare($sqlCara) ;
			$upCara->execute (array( $ambientes ,  $dormitorios , $antiguedad , $estado , $profesional , $terraza,  $luminosidad , $seguridad  , $suptotal , $supcubierta  , $banos , $toilette , $garage, $balcon , $patio , $jardin , $pileta , $id_caracteristica ) );
			
			$sqlDomi = "update domicilios set calle = ? , altura = ? , piso = ? , depto =?  where id_domicilio = ? "; 
			$upDomi = $this->db->prepare($sqlDomi) ;
			$upDomi->execute(array($calle , $altura , $piso , $depto , $id_domicilio ) ) ;
			
			$sqlUpAv ="update avisos set codigoficha = ? , id_localidad = ? , descripcion = ? where id_aviso = ? " ;
			$upAv = $this->db->prepare($sqlUpAv) ;
			$upAv->execute(array ($ficha , $localidad , $descripcion , $idAviso ) ) ;
			
			$this->db->commit();	
			return "OK" ;
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			return $e->getMessage();
		}
		
	}
	public function deleteAviso ($idAviso)
	{
		try
		{
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			$sqlAviso = "select id_caracteristica , id_dato_basico , id_domicilio  from avisos where id_aviso = :id_aviso" ;
			$stm_aviso = $this->db->prepare($sqlAviso) ;
			$stm_aviso ->execute(array(':id_aviso' => $idAviso  ) ) ;
			$phpAviso = $stm_aviso->fetch(PDO::FETCH_ASSOC);
			
			$id_caracteristica  = $phpAviso['id_caracteristica'] ;
			$id_dato_basico  = $phpAviso['id_dato_basico'] ;
			$id_domicilio = $phpAviso['id_domicilio'] ;
			
			$sqlDB = "delete from  datos_basicos  where id_dato_basico = ? " ;
			$upDB = $this->db->prepare($sqlDB) ; 
			$upDB->execute(array($id_dato_basico ) ) ;

			
			$sqlCara = "delete from caracteristicas  where id_caracteristica = ? ";
			$upCara = $this->db->prepare($sqlCara) ;
			$upCara->execute (array($id_caracteristica ) );
			
			$sqlDomi = "delete from domicilios where id_domicilio = ? "; 
			$upDomi = $this->db->prepare($sqlDomi) ;
			$upDomi->execute(array($id_domicilio ) ) ;
			
			$sqlFoto = "delete from fotos where id_aviso = ?" ;
			$delFoto = $this->db->prepare($sqlFoto);
			$delFoto->execute(array($idAviso) );
			
			$sqlUpAv ="delete from avisos where id_aviso = ? " ;
			$upAv = $this->db->prepare($sqlUpAv) ;
			$upAv->execute(array ($idAviso ) ) ;
			
			$this->db->commit();	
			return "OK" ;
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			return $e->getMessage();
		}
	}
	
	
	public function getIdInmobiliaria($idUsuario)
	{
		$sql_inmo = 'select id_inmobiliaria  from inmobiliarias where id_usuario =  :id_usuario' ;
		$stm_inmo = $this->db->prepare($sql_inmo) ;
		$stm_inmo -> execute(array(':id_usuario' => $idUsuario  ) ) ;
		$phpinmo = $stm_inmo->fetch(PDO::FETCH_ASSOC);
			
		$idInmobiliaria = $phpinmo['id_inmobiliaria'] ;
		return $idInmobiliaria ;
	}
	public function getFotoAviso($idAviso, $orden)
	{
		$sql_inmo = 'select url  from fotos where id_aviso =  :id_aviso and orden = :orden' ;
		$stm_inmo = $this->db->prepare($sql_inmo) ;
		$stm_inmo -> execute(array(':id_aviso' => $idAviso  , ':orden' => $orden  ) ) ;
		/* $stm_inmo -> execute(array(':orden' => $orden  ) ) ; */
		$phpinmo = $stm_inmo->fetch(PDO::FETCH_ASSOC);
			
		$idInmobiliaria = $phpinmo['url'] ;
		return $idInmobiliaria ;
	}
	public function closeAviso()
	{
		$dir = 'uploads/'.$id_inmo ;
		
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

	public function updateFoto($url_log , $id_inmobiliaria)
	{
		try
		{
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			
			$sql_upFoto = "update inmobiliarias set url_log = ?  where id_inmobiliaria = ? " ;
			$upFoto = $this->db->prepare($sql_upFoto) ;
			$upFoto->execute (array ( $url_log , $id_inmobiliaria ) ) ;
			
			$this->db->commit();		
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			return $e->getMessage();
		}
		
	}
	public function updateFotoAviso($urlFoto, $id_aviso , $orden )
	{
		try
		{
echo "UPDATE FOTO";
			echo $urlFoto;
			echo $id_aviso ;
			echo $orden ;
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			
			$sql_upFoto = "update fotos  set url = ?  where id_aviso = ?  and orden = ? " ;
			$upFoto = $this->db->prepare($sql_upFoto) ;
			$upFoto->execute (array ( $urlFoto, $id_aviso , $orden ) ) ;
			
			
			$this->db->commit();		
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			return $e->getMessage();
		}
	}
	public function insertFotos($url , $id_aviso , $orden)
	{
		try{
		
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->beginTransaction();
		
		$sql_fotos ="INSERT INTO fotos (url, orden , id_aviso) values (:url , :orden , :id_aviso)";
		$stm_insert_db = $this->db->prepare($sql_fotos) ;
		$stm_insert_db->bindParam(':url' , $url ,PDO::PARAM_STR ) ;
		$stm_insert_db->bindParam(':orden' , $orden ,PDO::PARAM_STR ) ;
		$stm_insert_db->bindParam(':id_aviso' , $id_aviso ,PDO::PARAM_STR ) ;
		$stm_insert_db->execute() ;
		
		$this->db->commit();		
			
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			return $e->getMessage();
		}
		
		
	
	}
	public function getUserProfile($idUsuario)
	{
	
		$sql_profile =  " select 
						inmo.id_inmobiliaria as idInmobiliaria ,
						usu.usuario as usuario ,
						usu.pwd as pwd ,
						inmo.nombre  as razonSocial,
						inmo.cuit as cuit ,
						inmo.contacto as asesorComercial  , 
						tel.region as region , 
						tel.numero as numero , 
						mail.mail as mail , 
						inmo.URL as site , 
						pro.id_provincia as IdProvincia ,
						pro.descripcion as provincia ,
						par.id_partido as IdPartido ,
						par.descripcion as partido ,
						loca.id_localidad as IdLocalidad ,
						loca.descripcion as localidad ,
						domi.calle as direccion ,
						domi.altura as altura , 
						domi.piso  as piso ,
						domi.depto as depto ,
						inmo.url_log as url_log 
						FROM
						usuarios usu inner join 
						inmobiliarias  inmo on 
						usu.id_usuario = inmo.id_usuario  
						inner join domicilios domi on 
						domi.id_domicilio = inmo.id_domicilio 
						left join localidades loca on 
						loca.id_localidad = inmo.id_localidad  
						left join partidos par on 
						par.id_partido = loca.id_partido 
						left join provincias pro on 
						pro.id_provincia = par.id_provincia 
						left join telefonos tel on
						tel.id_inmobiliaria = inmo.id_inmobiliaria 
						left join mails mail on
						mail.id_inmobiliaria = inmo.id_inmobiliaria
						where usu.id_usuario = "  .$idUsuario  ; 
	
		$queryProfile = $this->db->prepare($sql_profile) ; 
		$queryProfile->execute() ; 
		return $queryProfile ; 
	}
	public function InsertAviso($id_tipo_inmueble, $id_tipo_operacion , $id_tipo_moneda , $precio  , $can_ambientes, $can_dormitorios, $antiguedad, $disposicion, $profesional, $terraza, $luminosidad, $seguridad , $sup_total, $sup_cubierta, $banos, $toilette , $garage , $balcon, $patio, $jardin, $pileta , $direccion, $altura , $piso , $depto , $id_inmobiliaria , $codigoficha , $id_localidad  , $descripcion , $fecha_alta , $id_estadoAviso)
	{
		try
		{
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			
			
			$sql_datosbasicos ="INSERT INTO datos_basicos (id_tipo_inmueble, id_tipo_operacion, id_tipo_moneda , precio) values (:id_tipo_inmueble, :id_tipo_operacion, :id_tipo_moneda, :precio)";
			$stm_insert_db = $this->db->prepare($sql_datosbasicos) ;
			$stm_insert_db->bindParam(':id_tipo_inmueble' , $id_tipo_inmueble ,PDO::PARAM_STR ) ;
			$stm_insert_db->bindParam(':id_tipo_operacion' , $id_tipo_operacion ,PDO::PARAM_STR ) ;
			$stm_insert_db->bindParam(':id_tipo_moneda' , $id_tipo_moneda ,PDO::PARAM_STR ) ;
			$stm_insert_db->bindParam(':precio' , $precio ,PDO::PARAM_STR ) ;
			$stm_insert_db->execute() ;
			
			$last_id_datosbasicos = $this->db->lastInsertId();
			
			
			$sql_caracteristicas = "INSERT INTO caracteristicas (can_ambientes,can_dormitorios, antiguedad, disposicion, profesional,terraza,luminosidad, seguridad , sup_total, sup_cubierta,banos, toilette , garage , balcon, patio, jardin, pileta ) 
			values (:can_ambientes, :can_dormitorios, :antiguedad, :disposicion, :profesional, :terraza, :luminosidad, :seguridad , :sup_total, :sup_cubierta, :banos, :toilette , :garage , :balcon, :patio, :jardin, :pileta ) " ;
			$stm_insert_carac = $this->db->prepare($sql_caracteristicas) ;
			$stm_insert_carac->bindParam(':can_ambientes' , $can_ambientes  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':can_dormitorios' , $can_dormitorios  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':antiguedad' , $antiguedad  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':disposicion' , $disposicion  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':profesional' , $profesional  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':terraza' , $terraza  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':luminosidad' , $luminosidad  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':seguridad' , $seguridad  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':sup_total' , $sup_total  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':sup_cubierta' , $sup_cubierta  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':banos' , $banos  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':toilette' , $toilette  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':garage' , $garage  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':balcon' , $balcon  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':patio' , $patio  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':jardin' , $jardin  , PDO::PARAM_STR );
			$stm_insert_carac->bindParam(':pileta' , $pileta  , PDO::PARAM_STR );
			$stm_insert_carac->execute() ;
			
			$last_id_carac = $this->db->lastInsertId() ;
			
			$sql_dom = "INSERT INTO domicilios (calle , altura , piso , depto ) values 	(:calle , :altura , :piso , :depto)" ;
			$stm_insert_dom = $this->db->prepare($sql_dom);
			$stm_insert_dom->bindParam(':calle' , $direccion , PDO::PARAM_STR) ;
			$stm_insert_dom->bindParam(':altura' , $altura , PDO::PARAM_STR) ;
			$stm_insert_dom->bindParam(':piso' , $piso , PDO::PARAM_STR) ;
			$stm_insert_dom->bindParam(':depto' , $depto , PDO::PARAM_STR) ;
			$stm_insert_dom->execute() ;
			$last_id_dom = $this->db->lastInsertId();


			
			$sql_aviso ="INSERT INTO avisos (id_inmobiliaria , id_caracteristica , id_dato_basico , codigoficha , id_localidad , id_domicilio , descripcion , fecha_alta , id_estadoAviso)
			values (:id_inmobiliaria , :id_caracteristica , :id_dato_basico , :codigoficha , :id_localidad , :id_domicilio , :descripcion , :fecha_alta , :id_estadoAviso) " ;
			$stm_insert_aviso = $this->db->prepare($sql_aviso) ; 
			$stm_insert_aviso->bindParam(':id_inmobiliaria' , $id_inmobiliaria , PDO::PARAM_STR ) ;
			$stm_insert_aviso->bindParam(':id_caracteristica' , $last_id_carac  , PDO::PARAM_STR ) ;
			$stm_insert_aviso->bindParam(':id_dato_basico' , $last_id_datosbasicos , PDO::PARAM_STR ) ;
			$stm_insert_aviso->bindParam(':codigoficha' , $codigoficha , PDO::PARAM_STR ) ;
			$stm_insert_aviso->bindParam(':id_localidad' , $id_localidad , PDO::PARAM_STR ) ;
			$stm_insert_aviso->bindParam(':id_domicilio' , $last_id_dom , PDO::PARAM_STR ) ;
			$stm_insert_aviso->bindParam(':descripcion' , $descripcion , PDO::PARAM_STR ) ;
			$stm_insert_aviso->bindParam(':fecha_alta' , $fecha_alta , PDO::PARAM_STR ) ;
			$stm_insert_aviso->bindParam(':id_estadoAviso' , $id_estadoAviso , PDO::PARAM_STR ) ;
			$stm_insert_aviso->execute();
			$last_id_aviso = $this->db->lastInsertId() ;
			
			$this->db->commit();		
			
			return $last_id_aviso;
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			return $e->getMessage();
		}
	}


	public	function getDataCustomer($id_user) 
	{
		$sqlDC= "select usu.usuario , inmo.nombre as razonSocial , ro.rol , inmo.url_log as logo, inmo.id_inmobiliaria as idInmobiliaria  from usuarios usu inner join inmobiliarias inmo on usu.id_usuario = inmo.id_usuario
				inner join roles ro on ro.id_rol = usu.id_rol where usu.id_usuario = " .$id_user ." ";
				
		$DataUser = $this->db->prepare($sqlDC) ;
        $DataUser->execute()  ;
		
		return $DataUser ; 
		
	}
	public function getAvisotoEdit($idAviso)
	{
	
		$sqlga = "select 
					tipo_oper.descripcion  as operacion,
					tipo_oper.id_tipo_operacion as idtipooperacion ,
					tipo_inmu.descripcion as tipoinmueble,	
					tipo_inmu.id_tipo_inmueble as idtipoinmueble ,
					avi.codigoficha  as codigoficha,
					tipo_mone.id_tipo_moneda as idtipomoneda ,
					tipo_mone.descripcion as moneda,
					db.precio as precio,
					pro.descripcion as provincia,
					pro.id_provincia as idprovincia ,
					par.descripcion as partido ,
					par.id_partido as idpartido ,
					loca.descripcion as localidad,
					loca.id_localidad as idlocalidad ,
					domiAvi.calle as calle , 		  
					domiAvi.altura as altura ,
					domiAvi.piso as piso ,
					domiAvi.depto as depto ,
					cara.sup_total as suptotal ,
					cara.sup_cubierta as supcubierta ,
					cara.can_ambientes as ambientes,
					cara.can_dormitorios as dormitorios,
					cara.banos as banos ,
					cara.toilette as toilette ,
					cara.antiguedad as antiguedad,
					cara.disposicion as estado ,
					cara.luminosidad as luminosidad , 
					cara.terraza  as terraza , 
					cara.balcon as balcon ,
					cara.patio as patio ,
					cara.pileta  as pileta ,
					cara.jardin as jardin ,
					cara.garage as garage ,
					cara.seguridad as seguridad ,
					cara.profesional as profesional,
					avi.descripcion as descripcion ,
					inmo.id_inmobiliaria as idimobiliaria ,
					avi.id_aviso as idaviso 
					FROM  avisos avi  INNER JOIN  inmobiliarias inmo ON inmo.id_inmobiliaria = avi.id_inmobiliaria 
					INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
					INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
					INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
					INNER JOIN partidos par ON par.id_partido = loca.id_partido
					INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
					INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
					inner join tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
					inner join tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
					inner join domicilios domiAvi on domiAvi.id_domicilio = avi.id_domicilio
					WHERE inmo.habilitada = 1 and avi.id_aviso = ".$idAviso  ;
					
		$DataAviso = $this->db->prepare($sqlga) ;
        $DataAviso->execute()  ;
		
		return $DataAviso ; 
	}
	public function fotosAviso($idAviso)
    {
        $sql_fa = 'select url , orden  from fotos  where id_aviso =' .$idAviso.' order by  orden' ; 
        $fotos  = $this->db->prepare($sql_fa) ;
        $fotos->execute() ;
        return $fotos;
    }
}
?> 