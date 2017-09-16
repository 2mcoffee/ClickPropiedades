<?php
class DetailController
{
    function __construct()
    {
		  $this->view = new View();
    }
    public function listar()
    {

		require 'models/DetailModel.php';
        $detail = new DetailModel();
		
		
		$detalleinmueble = $detail->detalleAviso();
		$fotos = $detail->fotosAviso()   ;
                           
		$provincias = $detail->listadoProvincias() ;
		$edificaciones = $detail->listadoEdificaciones();
		 $operaciones = $detail->listadoOperaciones(); 

		$data['provincias'] = $provincias ;
		$data['edificaciones'] = $edificaciones ;
		$data['operaciones'] = $operaciones ; 
						   
						   
		$data['detalle'] = $detalleinmueble ;
		$data['fotos'] = $fotos ;
		
		$detail->insertaAviso() ;
		
        $this->view->showSearch("Details.php", $data);
    }
	 function getFiltrosAplicados()
	{
		$filtros = array() ;
	
		
		if (! empty($_POST['localidad'] ))
			$filtros['localidad'] = $this->model->get_Localidad_x_id() ;
		
		if (! empty($_POST['operacion'] ))
			$filtros['operacion'] =  $this->model->get_Operacion_x_id() ;
		
		if (! empty($_POST['edificacion'] ))
			$filtros['tipoInmueble'] =  $this->model->get_Edificacion_x_id() ;
			
		if (! empty($_POST['provincia'] ))
			$filtros['provincia'] =  $this->model->get_Provincia_x_id() ;
		
		if (! empty($_POST['ambientes'] ))
			$filtros['ambientes'] = $_POST['ambientes'] ;
		
		return $filtros ;
		
	}
}
?>