<?php
class PostbackController
{
	function __destruct ( )
	{
	}
	
    function __construct()
    {
		   $this->view = new View();
		   require 'models/PostbackModel.php';
		   $this->model = new PostbackModel();
		   echo $mensaje ;
    }
  
	public function showRegister()
	{

		$provincias = $this->model->listadoProvincias() ;
		$data['provincias'] =$provincias ;
		$data['mensaje'] = $_POST['mensaje'] ;
		$this->view->showInitialRegister("registerview.php",  $data ) ;
	}
}
?>