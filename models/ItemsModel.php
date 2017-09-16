<?php
class ItemsModel
{
    protected $db;

    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    public function listadoTotal()
    {
        //realizamos la consulta de todos los items
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
		$consulta = $this->db->prepare('select id_provincia, descripcion from provincias');
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
 d_b.precio as precio , t_m.descripcion as moneda , avi.id_aviso as IdAviso ,  inmo.id_inmobiliaria as IdImobiliaria 
 from destacados des inner join avisos avi on des.id_aviso = avi.id_aviso 
													 inner join inmobiliarias inmo on inmo.id_inmobiliaria = avi.id_inmobiliaria
													 inner join fotos f on f.id_foto = avi.id_foto 
													 inner join localidades l on l.id_localidad = avi.id_localidad 
													 inner join datos_basicos d_b on d_b.id_dato_basico = avi.id_dato_basico
													 inner join tipo_operaciones t_o on t_o.id_tipo_operacion = d_b.id_tipo_operacion
													 inner join tipo_monedas t_m on t_m.id_tipo_moneda = d_b.id_tipo_moneda
													 inner join tipo_inmuebles t_i on t_i.id_tipo_inmueble = d_b.id_tipo_inmueble
													 where inmo.habilitada =  1 order by des.orden 
												');
        $consulta->execute();
        return $consulta;
	}
}
?>