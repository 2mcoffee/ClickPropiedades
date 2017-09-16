<?php
/* 	include(__DIR__ .'/libs/SPDO.php') ;  */
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}libs{$ds}SPDO.php");

	
	
	if(isset($_POST['idProvincia'])) {
		
		
		$partidos = array();		
		
		$sql = "SELECT id_partido, descripcion
				FROM partidos
				WHERE id_provincia =".$_POST['idProvincia']." ORDER BY descripcion"; 
				
		 $db = obtenerConexion();
		 $result = ejecutarQuery($db, $sql);

		  while($row = $result->fetch_assoc()){
			 $partido = new partido($row['id_partido'], $row['descripcion']);
		      array_push($partidos, $partido);
		  }
		 
		cerrarConexion($db, $result);
		
		echo json_encode($partidos);
	}
	
	class partido {
		public $id;
		public $nombre;

		function __construct($id, $nombre) {
			$this->id = $id;
			$this->nombre = $nombre;
		}
	}
?>