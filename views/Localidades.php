<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}libs{$ds}SPDO.php");
	
	if(isset($_POST['idPartido'])) {
		$localidades = array();
		/* $sql = "SELECT loca.id_localidad, loca.descripcion
				FROM localidades loca 
				inner join partidos par on loca.id_partido = par.id_partido
				inner join provincias pro on pro.id_provincia = par.id_provincia
				WHERE pro.id_provincia  =".$_POST['idProvincia'];  */
		$sql = "SELECT loca.id_localidad, loca.descripcion
				FROM localidades loca 
				WHERE loca.id_partido  =".$_POST['idPartido']." ORDER BY loca.descripcion";
				 
				
		$db = obtenerConexion();
		$result = ejecutarQuery($db, $sql);
		while($row = $result->fetch_assoc()){
			$localidad = new localidad($row['id_localidad'], $row['descripcion']);
		    array_push($localidades, $localidad);
		}
		cerrarConexion($db, $result);
		echo json_encode($localidades);
	}
	
	class localidad {
		public $id;
		public $nombre;

		function __construct($id, $nombre) {
			$this->id = $id;
			$this->nombre = $nombre;
		}
	}
?>