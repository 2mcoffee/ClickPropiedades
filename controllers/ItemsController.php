<?php
class ItemsController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
    }

    public function listar()
    {
        //Incluye el modelo que corresponde
        require 'models/ItemsModel.php';
		
		
        //Creamos una instancia de nuestro "modelo"
        $items = new ItemsModel();

        //Le pedimos al modelo todos los items
        $listado = $items->listadoTotal();
		$usuarios = $items->listadoUsuarios() ;
		$destacados = $items->listadoDestacados();
		$provincias = $items->listadoProvincias() ;
		$destacados = $items->listadoDestacados() ;
		
		
		
			

		
        $data['listado'] = $listado;
		$data['usuarios'] = $usuarios;
		$data['destacados'] = $destacados;
		$data['provincias'] = $provincias ;
		$data['destacados'] = $destacados ;
		
	


        //Finalmente presentamos nuestra plantilla
        $this->view->show("listar.php", $data);

    }

    public function agregar()
    {
        echo 'Aquí incluiremos nuestro formulario para insertar items';
    }
}
?>