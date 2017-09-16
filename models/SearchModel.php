<?php
class SearchModel
{
    protected $db;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }
	public function getWhere()
	{
		if (! empty($_POST['localidad'] ))
			$where1 = " and avi.id_localidad = " .$_POST['localidad'] ;
		
		if (! empty($_POST['operacion'] ))
			$where2 = " and db.id_tipo_operacion = " .$_POST['operacion'] ;	
		
		if (! empty($_POST['edificacion'] ))
			$where3 = " and db.id_tipo_inmueble = " .$_POST['edificacion'] ;
		
		if (! empty($_POST['provincia'] ))
			$where4 = " and pro.id_provincia = " .$_POST['provincia']	;
			
		if (! empty($_POST['partido'] ))
			$where5 = " and par.id_partido  = " .$_POST['partido']	;
		
		if (! empty($_POST['ambientes'] ))
		{
			if ($_POST['ambientes'] > 3)
				$where6 = " and cara.can_ambientes > " .$_POST['ambientes'] ;
			else
				$where6 = " and cara.can_ambientes = " .$_POST['ambientes'] ;
		}
			
		
		return $where1 .$where2 .$where3 .$where4 .$where5 .$where6  ; 
	}
	public function getLimit()
	{
	
		/* $limits = " limit " .$_POST['hasta'] . " offset " .$_POST['desde'] ; */
/* 		echo "get" ;
		echo $_GET['page'] ; */
		if (isset($_GET['page'])) 
		{ 
			$page = $_GET['page']; 
		} else { $page=1; }; 
		
		$start_from = ($page - 1) * 20;

		$limits = " limit ". $start_from ."  , 20 ";
		
		return $limits ;
	}
	
	public function listadoGeneralDetails( )
	{	
		$where = $this->getWhere();	 
		$limit = $this->getLimit();	 
		
		$condition = $where . " order by destaca.orden desc , avi.fecha_alta desc  " .$limit ;
	
	$s = 'select 
		 avi.id_aviso as idAviso ,
		  inmo.id_inmobiliaria as IdImobiliaria ,
		  inmo.nombre as NombreInmobiliaria , 
		  inmo.url_log as fotoInmobiliaria , 
		 ( CASE when destaca.id_aviso is null then 0 else 1 end )as destacados ,
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
		 INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
		 INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
		 INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
		 INNER JOIN partidos par ON par.id_partido = loca.id_partido
		 INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
		 INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
		 inner join tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
		 left join tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
		 inner join domicilios domiAvi on domiAvi.id_domicilio = avi.id_domicilio
		 inner join domicilios domiInmo on domiInmo.id_domicilio = inmo.id_domicilio
		 left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
		 WHERE inmo.habilitada = 1  ' .$condition ;

		 
		$detalles = $this->db->prepare($s) ;
		$detalles -> execute();
        return $detalles ;
	}
	public function listadoTotalRegistros()
	{
		$where = $this->getWhere();	 
	 
		$condition = $where ;
		
	$s = 'select count(*) as totalRegistros  
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
		 WHERE inmo.habilitada = 1  ' .$condition ;
		 
	
		$detalles = $this->db->prepare($s) ;
		$detalles -> execute();
        return $detalles ;		
	}
	public function listadoFiltroLocalidades()
	{
		$where = $this->getWhere();	 

		$condition = $where . " group by avi.id_localidad" ;
		
		$sql = 'select loca.descripcion as localidad,  count(*) as total  
				FROM  avisos avi  INNER JOIN  inmobiliarias inmo ON inmo.id_inmobiliaria = avi.id_inmobiliaria 
				INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
				INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
				INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
				INNER JOIN partidos par ON par.id_partido = loca.id_partido
				INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
				INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
				INNER JOIN tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
				INNER JOIN tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda

				left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
				where inmo.habilitada = 1  '  .$condition ;
				
		$filtros = $this->db->prepare($sql) ;
		$filtros -> execute () ;
		return $filtros ;
	}
		public function listadoFiltroPartido()
	{
		$where = $this->getWhere();	 

		$condition = $where . " group by avi.id_localidad" ;
		
		$sql = 'select par.descripcion as partido ,  count(*) as total  
				FROM  avisos avi  INNER JOIN  inmobiliarias inmo ON inmo.id_inmobiliaria = avi.id_inmobiliaria 
				INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
				INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
				INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
				INNER JOIN partidos par ON par.id_partido = loca.id_partido
				INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
				INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
				INNER JOIN tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
				INNER JOIN tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda

				left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
				where inmo.habilitada = 1  '  .$condition ;
				
		$filtros = $this->db->prepare($sql) ;
		$filtros -> execute () ;
		return $filtros ;
	}
	
	public function listadoFiltroMonedas()
	{	
				$where = $this->getWhere();	 
				$condition = $where . " group by db.id_tipo_moneda" ;
	
		$sql = 'select tipo_mone.descripcion as moneda ,  count(*) as total  
				FROM  avisos avi  INNER JOIN  inmobiliarias inmo ON inmo.id_inmobiliaria = avi.id_inmobiliaria 
				INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
				INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
				INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
				INNER JOIN partidos par ON par.id_partido = loca.id_partido
				INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
				INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
				INNER JOIN tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
				INNER JOIN tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
				left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
				where inmo.habilitada = 1 '  .$condition ;  
				
		$filtros = $this->db->prepare($sql) ;
		$filtros -> execute () ;
		return $filtros ;
	}
	public function listadoFiltroOperaciones()
	{	
			$where = $this->getWhere();	 
			$condition = $where . " group by db.id_tipo_operacion" ;
			
		$sql = 'select tipo_oper.descripcion as operacion ,  count(*) as total  
				FROM  avisos avi  INNER JOIN  inmobiliarias inmo ON inmo.id_inmobiliaria = avi.id_inmobiliaria 
				INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
				INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
				INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
				INNER JOIN partidos par ON par.id_partido = loca.id_partido
				INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
				INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
				INNER JOIN tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
				INNER JOIN tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
				left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
				where inmo.habilitada = 1  '  .$condition ;
				
		$filtros = $this->db->prepare($sql) ;
		$filtros -> execute () ;
		return $filtros ;
	}
	public function listadoFiltroEdificacion()
	{	
		$where = $this->getWhere();	 
		$condition = $where . " group by db.id_tipo_inmueble" ;
		
		$sql = 'select tipo_inmu.descripcion as inmueble ,  count(*) as total  
				FROM  avisos avi  INNER JOIN  inmobiliarias inmo ON inmo.id_inmobiliaria = avi.id_inmobiliaria 
				INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
				INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
				INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
				INNER JOIN partidos par ON par.id_partido = loca.id_partido
				INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
				INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
				INNER JOIN tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
				INNER JOIN tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
				left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
				where inmo.habilitada = 1  ' .$condition ;
				
		$filtros = $this->db->prepare($sql) ;
		$filtros -> execute () ;
		return $filtros ;
	}
	public function get_Localidad_x_id()
	{
		$sql_l = 'select descripcion as filtro from localidades where id_localidad  =  :id_localidad' ;
		$stm = $this->db->prepare($sql_l) ;
		$stm -> execute(array(':id_localidad' => $_POST['localidad'] ) ) ;
		$filtro_localidad = $stm->fetchColumn();
		return $filtro_localidad ;
	}
	public function get_Partido_x_id()
	{
		$sql_l = 'select descripcion as filtro from partidos where id_partido  =  :id_partido' ;
		$stm = $this->db->prepare($sql_l) ;
		$stm -> execute(array(':id_partido' => $_POST['partido'] ) ) ;
		$filtro_localidad = $stm->fetchColumn();
		return $filtro_localidad ;
	}
	public function get_Monedad_x_id()
	{
		$sql_m = 'select descripcion as filtro  from tipo_monedas =  :id_tipo_moneda' ;
		$stmM = $this->db->prepare($sql_m) ;
		$stmM -> execute(array(':id_tipo_moneda' => $_POST['localidad'] ) ) ;
		$filtro_moneda = $stmM ->fetch();
		return $filtro_moneda ;
	}
	public function get_Operacion_x_id()
	{
		$sql_o = 'select descripcion as filtro  from tipo_operaciones where id_tipo_operacion =  :id_tipo_operacion' ;
		$stm_o = $this->db->prepare($sql_o) ;
		$stm_o -> execute(array(':id_tipo_operacion' => $_POST['operacion'] ) ) ;
		$filtro_operacion = $stm_o->fetchColumn();
		return $filtro_operacion ;
	}
	public function get_Provincia_x_id()
	{
		 $sql_p = 'select descripcion as filtro  from provincias where id_provincia =  :id_provincia' ;
		 $stm_p = $this->db->prepare($sql_p) ;
		 $stm_p -> execute(array(':id_provincia' => $_POST['provincia'] ) ) ;
		 $filtro_pcia = $stm_p->fetchColumn();
		return $filtro_pcia ;
	}
		public function get_Edificacion_x_id()
	{
		$sql_e = 'select descripcion as filtro  from tipo_inmuebles where id_tipo_inmueble =  :id_tipo_inmueble' ;
		$stm_e = $this->db->prepare($sql_e) ;
		$stm_e -> execute(array(':id_tipo_inmueble' => $_POST['edificacion'] ) ) ;
		$filtro_edificacion= $stm_e ->fetchColumn();
		return $filtro_edificacion ;
	}
	
	public function listadoOperaciones()
	{
		$operaciones = $this->db->prepare('select id_tipo_operacion as id_operacion ,descripcion  as operacion from tipo_operaciones ' ) ;
		$operaciones -> execute();
        return $operaciones;
	}
	public function listadoEdificaciones()
	{
		$edificaciones = $this->db->prepare('select id_tipo_inmueble as id_edificacion , descripcion as edificacion from tipo_inmuebles' ) ;
		$edificaciones -> execute();
        return $edificaciones ;
	}
		public function listadoProvincias()
	{
		$consulta = $this->db->prepare('select id_provincia, descripcion from provincias');
	    $consulta->execute();
        return $consulta;
	}	

}
?> 