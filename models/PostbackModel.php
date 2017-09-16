<?php
class PostbackModel
{
    protected $db;
    public function __construct()
    {
        $this->db = SPDO::singleton();
    }
	public function listadoProvincias()
	{
		$consulta = $this->db->prepare('select id_provincia, descripcion from provincias');
	    $consulta->execute();
        return $consulta;
	}
}
?> 