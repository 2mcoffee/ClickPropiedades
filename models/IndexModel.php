<?php
class IndexModel
{
    protected $db;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }
    public function listadoTotal()
    {
        $consulta = $this->db->prepare('SELECT id_rol , rol FROM roles');
        $consulta->execute();
        return $consulta;
    }
	public function listadoUsuarios()
	{
		$consulta = $this->db->prepare('SELECT * FROM usuarios');
        $consulta->execute();
        return $consulta;
	}

	public function listadoProvincias()
	{
		$consulta = $this->db->prepare('select id_provincia, descripcion from provincias order by descripcion');
	    $consulta->execute();
        return $consulta;
	}
	public function listadoLocalidades($id_provincia)
	{
		$consulta = $this->db->prepare(' select id_localidad,descripcion from localidades where id_provincia =$id_provincia');
        $consulta->execute();
        return $consulta;
	}
	public function listadoDestacados()
	{
		$consulta = $this->db->prepare('select inmo.nombre  inmobiliaria ,  f.url as foto, t_i.descripcion  as tipoInmueble , l.descripcion as localidad , t_o.descripcion as tipoOperacion, 
 d_b.precio as precio , t_m.descripcion as moneda , pro.descripcion as provincia , avi.id_aviso as idAviso ,  inmo.id_inmobiliaria as IdImobiliaria 
 from destacados des inner join avisos avi on des.id_aviso = avi.id_aviso 
													 inner join inmobiliarias inmo on inmo.id_inmobiliaria = avi.id_inmobiliaria
													 inner join fotos f on f.id_aviso   = avi.id_aviso
													 inner join localidades l on l.id_localidad = avi.id_localidad
													 inner join partidos par on l.id_partido = par.id_partido
													 inner join provincias pro on pro.id_provincia = par.id_provincia
													 inner join datos_basicos d_b on d_b.id_dato_basico = avi.id_dato_basico
													 inner join tipo_operaciones t_o on t_o.id_tipo_operacion = d_b.id_tipo_operacion
													 inner join tipo_monedas t_m on t_m.id_tipo_moneda = d_b.id_tipo_moneda
													 inner join tipo_inmuebles t_i on t_i.id_tipo_inmueble = d_b.id_tipo_inmueble
													 where inmo.habilitada =  1 and f.orden = 1 order by avi.fecha_alta ');
        $consulta->execute();
        return $consulta;
	}
	public function listadoOperaciones()
	{
		$operaciones = $this->db->prepare('select id_tipo_operacion as id_operacion ,descripcion  as operacion from tipo_operaciones ' ) ;
		$operaciones -> execute();
        return $operaciones;
	}
	public function listadoEdificaciones()
	{
		$edificaciones = $this->db->prepare('select id_tipo_inmueble as id_edificacion , descripcion as edificacion from tipo_inmuebles order by orden ' ) ;
		$edificaciones -> execute();
        return $edificaciones ;
	}
	
	public function listadoAvisosCabecera()
	{
	$sql_avisoCabecera = 'select 
		 avi.id_aviso as idAviso ,
		  inmo.id_inmobiliaria as IdImobiliaria  ,
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
		 INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
		 INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
		 INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
		 INNER JOIN partidos par ON par.id_partido = loca.id_partido
		 INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
		 INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
		 inner join tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
		 inner join tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
		 inner join domicilios domiAvi on domiAvi.id_domicilio = avi.id_domicilio
		 inner join domicilios domiInmo on domiInmo.id_domicilio = inmo.id_domicilio
		 left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
		 WHERE inmo.habilitada = 1 order by avi.fecha_alta desc limit 2 offset 0 '  ;

		$dt_avisoCabecera = $this->db->prepare($sql_avisoCabecera) ;
		$dt_avisoCabecera->execute();
        return $dt_avisoCabecera ;
	}
	public function listadoAvisosFooter()
	{
	$sql_avisoFooter = 'select 
		 avi.id_aviso as idAviso ,
		  inmo.id_inmobiliaria as IdImobiliaria ,
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
		 INNER JOIN datos_basicos db ON db.id_dato_basico = avi.id_dato_basico 
		 INNER JOIN caracteristicas cara on cara.id_caracteristica = avi.id_caracteristica 
		 INNER JOIN localidades loca on avi.id_localidad = loca.id_localidad
		 INNER JOIN partidos par ON par.id_partido = loca.id_partido
		 INNER JOIN provincias pro ON pro.id_provincia = par.id_provincia
		 INNER JOIN tipo_operaciones tipo_oper on tipo_oper.id_tipo_operacion = db.id_tipo_operacion
		 inner join tipo_inmuebles tipo_inmu on tipo_inmu.id_tipo_inmueble = db.id_tipo_inmueble
		 inner join tipo_monedas tipo_mone ON tipo_mone.id_tipo_moneda = db.id_tipo_moneda
		 inner join domicilios domiAvi on domiAvi.id_domicilio = avi.id_domicilio
		 inner join domicilios domiInmo on domiInmo.id_domicilio = inmo.id_domicilio
		 left JOIN destacados destaca on destaca.id_aviso = avi.id_aviso 
		 WHERE inmo.habilitada = 1 order by avi.fecha_alta desc limit 4 offset 2 '  ;

		$dt_avisoFooter = $this->db->prepare($sql_avisoFooter) ;
		$dt_avisoFooter->execute();
        return $dt_avisoFooter ;
	}
	
}
?>