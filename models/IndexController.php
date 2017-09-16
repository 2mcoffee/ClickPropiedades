<?php
class IndexController
{
    function __construct()
    {
        
        $this->view = new View();
    }

    public function listar()
    {
        require 'models/IndexModel.php';
        $items = new IndexModel();
        
		$provincias = $items->listadoProvincias() ;
		$destacados = $items->listadoDestacados() ;
		$edificaciones = $items->listadoEdificaciones();
		$operaciones = $items->listadoOperaciones();
		$avisosCabecera = $items->listadoAvisosCabecera();
		$avisosFooter = $items->listadoAvisosFooter() ;
		
		$data['provincias'] = $provincias ;
		$data['destacados'] = $destacados ;
		$data['edificaciones'] = $edificaciones ;
		$data['operaciones'] = $operaciones ;
		$data['avisosCabecera'] = $avisosCabecera ; 
		$data['avisosFooter'] = $avisosFooter ;
	
        $this->view->show("home.php", $data);
	/* 	 Echo "<pre>"; 
		 print_R("avisosCabecera :  ") ;
print_R($data['avisosCabecera']) ;
print_R("avisosFooter :  ") ;
print_R($data['avisosFooter'] ) ; */
    }

}
?>