<?php
class AdminModel
{
    protected $db;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

	public function getProvincias()
	{
		$consultap = $this->db->prepare('select id_provincia, descripcion from provincias');
	    $consultap->execute();
        return $consultap;
	}
	public function insertLocalidad($nuevaLocalidad , $id_partido , $id_provincia )
	{
		$sqll ="select COALESCE(max(id_localidad),0) + 1 as max from localidades ";
		$localidad = $this->db->prepare($sqll) ;
		$localidad->execute() ;
		$max = $localidad->fetch() ;
		$maxLocalidad = $max['max'] ;
		
		$sqlI= "insert into localidades (id_localidad , descripcion , id_partido, id_provincia ) values (:id_localidad , :descripcion , :id_partido , :id_provincia )";
		$stm_insertl_db = $this->db->prepare($sqlI) ;
		$stm_insertl_db->bindParam(':id_localidad' , $maxLocalidad ,PDO::PARAM_INT ) ;
		$stm_insertl_db->bindParam(':descripcion' , $nuevaLocalidad ,PDO::PARAM_STR ) ;
		$stm_insertl_db->bindParam(':id_partido' , $id_partido ,PDO::PARAM_INT ) ;
		$stm_insertl_db->bindParam(':id_provincia' , $id_provincia ,PDO::PARAM_INT ) ;
		
		$stm_insertl_db->execute() ;		
		
		return ; 
	}
	public function insertPartido($nuevoPartido ,  $id_provincia)
	{
		$sqlp ="select COALESCE(max(id_partido),0) + 1 as max from partidos ";
		$partido = $this->db->prepare($sqlp) ;
		$partido->execute() ;
		$max = $partido->fetch() ;
		$maxpartido = $max['max'] ;
		
		echo $maxpartido ; echo " - ";		 echo $id_provincia; 
		$sqlp= "insert into partidos (id_partido , descripcion , id_provincia ) values (:id_partido , :descripcion , :id_provincia )";
		$stm_insertp_db = $this->db->prepare($sqlp) ;
		$stm_insertp_db->bindParam(':id_partido' , $maxpartido ,PDO::PARAM_INT ) ;
		$stm_insertp_db->bindParam(':descripcion' , $nuevoPartido ,PDO::PARAM_STR ) ;
		$stm_insertp_db->bindParam(':id_provincia' , $id_provincia ,PDO::PARAM_INT ) ;
		
		$stm_insertp_db->execute() ;		
		
		return ; 
	}
	public function deleteLocalidad($id_localidad , $id_partido , $id_provincia)
	{		
		$sqd = "delete from localidades where id_localidad = ? and id_partido = ? and id_provincia = ? " ;
		$deletel = $this->db->prepare($sqd);
		$deletel->execute(array($id_localidad , $id_partido , $id_provincia ) );
		return ;
	}
	public function deletePartido($id_partido ,  $id_provincia)
	{
		$sqlL="delete from localidades where id_partido = ? and id_provincia = ? " ;
		$deletel = $this->db->prepare($sqlL);
		$deletel->execute(array($id_partido , $id_provincia) );
		
		$sqp = "delete from partidos where id_partido = ? and id_provincia = ? " ;
		$deletep = $this->db->prepare($sqp);
		$deletep->execute(array($id_partido , $id_provincia ) );
		return ;
	}
    public function getInmobiliariasHabilitadas()
    {
        //realizamos la consulta de todos los items
        $consulta = $this->db->prepare('Select id_inmobiliaria as id , nombre from inmobiliarias where habilitada = 1 order by nombre ');
        $consulta->execute();
        return $consulta;
    }
	public function getInmobiliariasDeshabilitadas()
	{
		$consulta = $this->db->prepare('Select id_inmobiliaria as id , nombre from inmobiliarias where habilitada = 0 order by nombre ');
        $consulta->execute();
        return $consulta;
	}
	public function getInmobiliariasconDestacados()
	{
		$sqlD="SELECT avi.id_aviso as id , concat_ws(' - ', avi.id_aviso ,inmo.nombre,    ti.descripcion , toper.descripcion,  loca.descripcion , tm.descripcion , db.precio )  as  nombre FROM inmobiliarias inmo inner join avisos avi on avi.id_inmobiliaria = inmo.id_inmobiliaria inner join destacados des on des.id_aviso = avi.id_aviso inner join  localidades loca on avi.id_localidad = loca.id_localidad inner join datos_basicos db on avi.id_dato_basico = db.id_dato_basico  inner join  tipo_operaciones toper on db.id_tipo_operacion = toper.id_tipo_operacion inner join tipo_inmuebles ti on db.id_tipo_inmueble = ti.id_tipo_inmueble inner join tipo_monedas tm on tm.id_tipo_moneda = db.id_tipo_moneda WHERE inmo.habilitada = 1 " ;
		/* and id_inmobiliaria IN ( SELECT id_inmobiliaria FROM avisos a INNER JOIN destacados d ON a.id_aviso = d.id_aviso ) order by nombre " ; */
		$consultad = $this->db->prepare($sqlD);
        $consultad->execute();
        return $consultad;
	}
	public function altaDestacado($id_aviso)
	{
		$sqlm ="select COALESCE(max(id_destacado),0) + 1 as max from destacados ";
		$destacados = $this->db->prepare($sqlm) ;
		$destacados->execute() ;
		$maxDestacado = $destacados->fetch() ;
		$max = $maxDestacado['max'] ;
		
		
		$sqlI= "insert into destacados (id_destacado , id_aviso) values (:id_destacado , :id_aviso)";
		$stm_insert_db = $this->db->prepare($sqlI) ;
		$stm_insert_db->bindParam(':id_destacado' , $max ,PDO::PARAM_INT ) ;
		$stm_insert_db->bindParam(':id_aviso' , $id_aviso ,PDO::PARAM_INT ) ;
	
		$stm_insert_db->execute() ;
		
		return ; 
	}
	public function bajaDestacado ($id_aviso)
	{
		$sq = "delete from destacados where id_aviso = ? " ;
		$update = $this->db->prepare($sq);
		$update->execute(array($id_aviso  ) );
		return ;
	}
	public function setEstadoInmobiliaria($id_inmobiliaria, $estado)
	{
		try
		{
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->beginTransaction();
			
			$sq = "update inmobiliarias set habilitada = ? where id_inmobiliaria = ? " ;
			$update = $this->db->prepare($sq);
			$update->execute(array($estado , $id_inmobiliaria  ) );
			
			$this->db->commit();	
 
			return ;
		}
		catch(Exception $e)
		{ 
			$this->db->rollback();
	
			echo $e->getMessage();
		}
	}
	public function getPlanInmobiliarias()
	{
		$sqlp ="SELECT inmo.id_inmobiliaria  as id_inmobiliaria , CONCAT_WS(  ' - ',  inmo.nombre,  'Tipo Plan', tp.descripcion,  'Avisos', tp.cantidad_inmueble ) as PlanInmobiliarias FROM inmobiliarias inmo INNER JOIN tipo_plan_inmobiliarias tp ON inmo.id_tipo_plan = tp.id_tipo_plan order by inmo.nombre" ;
		$pi= $this->db->prepare($sqlp) ; 	
		$pi->execute() ;
		return $pi ;
	}
	public function getPlanes()
	{
		$sqlP ="select  id_tipo_plan , concat_ws( ' - ', id_tipo_plan , 'Plan', descripcion , 'Avisos', cantidad_inmueble) as descripcionPlan from tipo_plan_inmobiliarias " ;
		$p = $this->db->prepare($sqlP) ; 	
		$p->execute() ;
		return $p ;
	}
	public function updatePlanInmobiliaria($id_tipo_plan, $id_inmobiliaria)
	{
		$sqlu = "update inmobiliarias set id_tipo_plan = ?   where id_inmobiliaria = ? " ;
		$update = $this->db->prepare($sqlu);
		$update->execute(array($id_tipo_plan , $id_inmobiliaria  ) );
		return ; 
	}
}
?>