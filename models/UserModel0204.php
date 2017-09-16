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
		$edificaciones = $this->db->prepare('select id_tipo_inmueble as id_edificacion , descripcion as edificacion from tipo_inmuebles' ) ;
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
		 where inmo.id_usuario = " .$id_usuario ." order by avi.id_aviso limit " .$limit ." offset " .$offset." ";
		 
	
		 
		$customer = $this->db->prepare($sql_user) ;
        $customer->execute()  ;
		
		return $customer ; 
	}
	

	public function updateProfile()
	{
		$sql_upLogo = "update inmobiliarias set nombre = ? , cuit = ? , url = ?, url_log = ? , contacto = ?   , id_localidad = ? where id_inmobiliaria = ? " ;
		$uplogo = $this->db->prepare($sql_upLogo);
		$uplogo->execute(array($nNombre,$last_id_inmo));
		
		$sql_upLogo = "update domicilios set calle = ? , altura = ? ,  piso = ? , depto = ? where id_domicilio = ?" ;
		$updom = $this->db->prepare($sql_upLogo) ;
		$updom->execute(array() ) ;
		
		$sql_upLogo = "update mails set mail = ?  where id_mail = ? ";
		$upmail = $this->db->prepare($sql_upLogo) ;
		$upmail->execute(array() ) ; 

		$sql_upLogo = "update telefonos set numero = ? , region = ? , movil = ? where id_telefono = ? ";
		$uptele = $this->db->prepare($sql_upLogo) ; 
		$uptele->execute(array() ) ;
		
		/*agregar el update de foto si corresponde*/
		
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
	public function changeStateAviso()
	{
	
	}

	public function getUserProfile($idUsuario)
	{
		$sql_profile =  "
						select 
						usu.usuario as usuario ,
						inmo.id_inmobiliaria as idInmobiliaria,
						inmo.nombre  as inmobiliaria,
						inmo.cuit as cuit ,
						inmo.url_log as url_log, 
						inmo.URL as site , 
						inmo.contacto as contacto  , 
						domi.calle as direccion ,
						domi.altura as altura , 
						domi.piso  as piso ,
						tel.numero as numero , 
						tel.region as region , 
						tel.movil as movil  
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
						where usu.id_usuario = "  .$idUsuario  ; 
	
		$queryProfile = $this->db->prepare($sql_profile) ; 
		$queryProfile->execute() ; 
		return $queryProfile ; 
	}
	public function InsertAviso($id_tipo_inmueble, $id_tipo_operacion , $id_tipo_moneda , $precio  , $can_ambientes, $can_dormitorios, $antiguedad, $disposicion, $profesional, $terraza, $luminosidad, $seguridad , $sup_total, $sup_cubierta, $banos, $toilette , $garage , $balcon, $patio, $jardin, $pileta , $direccion, $altura , $piso , $depto , $id_inmobiliaria , $id_caracteristica , $id_dato_basico , $codigoficha , $id_localidad , $id_domicilio , $descripcion , $fecha_alta , $id_estadoAviso)
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
}
?> 