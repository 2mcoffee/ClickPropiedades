<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}libs{$ds}SPDO.php");
	
	
 	if(isset($_POST['Idinmobiliaria'])) { 
		$avisos = array();

		$sql = "select id_aviso , CONCAT_WS(  ' - ', id_aviso ,  ti.descripcion , toper.descripcion,  loca.descripcion , tm.descripcion, db.precio ) as descripcion from avisos a inner join localidades loca on a.id_localidad = loca.id_localidad inner join datos_basicos db on a.id_dato_basico = db.id_dato_basico  inner join  tipo_operaciones toper on db.id_tipo_operacion = toper.id_tipo_operacion inner join tipo_inmuebles ti on db.id_tipo_inmueble = ti.id_tipo_inmueble inner join tipo_monedas tm on tm.id_tipo_moneda = db.id_tipo_moneda WHERE a.id_inmobiliaria  =".$_POST['Idinmobiliaria']; 
	/* 	$sql= "select id_aviso , id_dato_basico as descripcion from avisos ";	 */	
				
		$db = obtenerConexion();
		$result = ejecutarQuery($db, $sql);
		while($row = $result->fetch_assoc()){
			$aviso = new aviso($row['id_aviso'], $row['descripcion']);
		    array_push($avisos, $aviso);
		}
		cerrarConexion($db, $result);
		echo json_encode($avisos);
 	} 
	
	class aviso {
		public $id;
		public $nombre;

		function __construct($id, $nombre) {
			$this->id = $id;
			$this->nombre = $nombre;
		}
	}
?>