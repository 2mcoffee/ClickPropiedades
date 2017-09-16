<?php
class SearchController
{
    function __construct()
    {
        $this->view = new View();
		require 'models/SearchModel.php';
		$this->model = new SearchModel();
    }
    public function listar()
    {
        // require 'models/SearchModel.php';
        // $details = new SearchModel();
		

		/* if ($this->isGet() )  */
		$this->fillPost() ; 
		
		$detalle = $this->model->listadoGeneralDetails()  ;
		$cantidadRegistros = $this->model->listadoTotalRegistros();
		$filtroLocalidad = $this->model->listadoFiltroLocalidades() ;
		$filtroMoneda = $this->model->listadoFiltroMonedas() ;
		$filtroOperacion = $this->model->listadoFiltroOperaciones() ;
		$filtroEdificacion = $this->model->listadoFiltroEdificacion() ;
		$filtroPartido = $this->model->listadoFiltroPartido() ;
		
		$data['salidaCentral'] = $detalle ;
		$data['salidaTotalRegistros'] = $cantidadRegistros ;
		$data['salidaFiltroLocalidad'] = $filtroLocalidad ;
		$data['salidaFiltroMoneda'] = $filtroMoneda ;
		$data['salidaFiltroOperacion'] = $filtroOperacion ;
		$data['salidaFiltroEdificacion'] = $filtroEdificacion ;
		$data['salidaFiltroPartido'] = $filtroPartido ;
		$data['salidaFiltros'] = $this->getFiltrosAplicados();
		
			
		
		$data['salidaFiltrosAplicados'] = $this->getFiltrosAplicados_x_Id();
		
		
		// Para combos 
		
		$provincias = $this->model->listadoProvincias() ;
		$edificaciones = $this->model->listadoEdificaciones();
		$operaciones = $this->model->listadoOperaciones();

		$data['provincias'] = $provincias ;
		$data['edificaciones'] = $edificaciones ;
		$data['operaciones'] = $operaciones ;
		
        $this->view->showSearch("Search.php", $data);
		
/* 			Echo "<pre>"; 
		print_R($data['salidaCentral']) ; */	
    }
	 private function fillPost()
	 {
		if (! empty($_GET['localidad'] ))
			$_POST['localidad'] = $_GET['localidad'];
			
		if (! empty($_GET['partido'] ))
			$_POST['partido'] = $_GET['partido'];
			
		if (! empty($_GET['provincia'] ))
			$_POST['provincia'] =  $_GET['provincia'];		
		
		if (! empty($_GET['operacion'] ))
			$_POST['operacion'] =  $_GET['operacion'];
		
 		if (! empty($_GET['edificacion'] ))
			$_POST['edificacion'] =  $_GET['edificacion'] ;
		
		if (! empty($_GET['ambientes'] ))
			$_POST['ambientes'] = $_GET['ambientes'] ; 
			
	 }
/* 	 private function isGet()
	 {
	 	if (! isset($_GET['page'])) 
			RETURN TRUE;
		else
			RETURN FALSE;
	
	 } */
	 function getFiltrosAplicados_x_Id()
	 {
	 	$filtros_x_Id = array() ;

		if (! empty($_POST['partido'] ))
			$filtros_x_Id['partido'] = $_POST['partido'];
		
		if (! empty($_POST['localidad'] ))
			$filtros_x_Id['localidad'] = $_POST['localidad'];
		
		if (! empty($_POST['operacion'] ))
			$filtros_x_Id['operacion'] =  $_POST['operacion'];
		
		if (! empty($_POST['edificacion'] ))
			$filtros_x_Id['edificacion'] =  $_POST['edificacion'] ;
			
		if (! empty($_POST['provincia'] ))
			$filtros_x_Id['provincia'] =  $_POST['provincia'];
		
		if (! empty($_POST['ambientes'] ))
			$filtros_x_Id['ambientes'] = $_POST['ambientes'] ;
		
		return $filtros_x_Id ;
	 }
	 function getFiltrosAplicados()
	{
		$filtros = array() ;
		
		if (! empty($_POST['provincia'] ))
			$filtros['Provincia'] =  $this->model->get_Provincia_x_id() ;
		
		if (! empty($_POST['partido'] ))
			$filtros['Partido'] = $this->model->get_Partido_x_id() ;
			
		if (! empty($_POST['localidad'] ))
			$filtros['Localidad'] = $this->model->get_Localidad_x_id() ;
		
		if (! empty($_POST['operacion'] ))
			$filtros['Operacion'] =  $this->model->get_Operacion_x_id() ;
		
		if (! empty($_POST['edificacion'] ))
			$filtros['Edificacion'] =  $this->model->get_Edificacion_x_id() ;
			
	
			
		
		
		if (! empty($_POST['ambientes'] ))
			$filtros['Ambientes'] = $_POST['ambientes'] ;
			
		
		return $filtros ;
		
	}
}
?>