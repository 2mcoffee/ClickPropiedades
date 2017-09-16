<?php
class AdminController
{
    function __construct()
    {
        $this->view = new View();
		IF(empty($_SESSION['User']) )
		{
			session_destroy();
			$this->view->showInvalido("login.php","Inicie sesión con su usuario y clave.");
			exit ; 
		}
		else
		{
			if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 10000)) 
			{
				session_unset();
				session_destroy();	
				$this->view->showInvalido("login.php" , "La sesión ha finalizado. Vuelva a ingresar al sistema.");
				exit ;
			}	
			else
				$_SESSION['LAST_ACTIVITY']	 = time() ;
		}
    }

    public function Accesos()
    {
        require 'models/AdminModel.php';
        $AdminModel = new AdminModel(); 
		$InmobiliariasHabilitadas = $AdminModel->getInmobiliariasHabilitadas();	
		$InmobiliariasDeshabilitadas = $AdminModel->getInmobiliariasDeshabilitadas();	
		
		$dataAccess['InmobiliariasHabilitadas'] = $InmobiliariasHabilitadas ;
		$dataAccess['InmobiliariasDeshabilitadas'] = $InmobiliariasDeshabilitadas ; 
		
        $this->view->showAccesosAdmin("agency.php" , $dataAccess );
    }
	public function destacados()
	{
		require 'models/AdminModel.php';
        $AdminD = new AdminModel(); 
		
		$destacados = $AdminD->getInmobiliariasconDestacados() ;
		$InmobiliariasHabilitadas = $AdminD->getInmobiliariasHabilitadas();	
		
		$dataDes['InmobiliariasHabilitadas'] = $InmobiliariasHabilitadas ;
		$dataDes['InmobiliariasDeshabilitadas'] = $destacados ; 
		
		$this->view->showAccesosAdmin("featured.php" , $dataDes );
		
	}
	public function cambioPlan()
	{
		require 'models/AdminModel.php';
        $modelA = new AdminModel(); 
		$salidaPlan =  $modelA->getPlanInmobiliarias() ;
		$planes = $modelA->getPlanes () ;

		while($des = $salidaPlan->fetch() )
		{
			$salidaInmo.= "<option value='".$des['id_inmobiliaria']."'>".$des['PlanInmobiliarias']."</option>";
		} 	
		while($desp = $planes->fetch() )
		{
			$salidaPlanNuevo.= "<option value='".$desp['id_tipo_plan']."'>".$desp['descripcionPlan']."</option>";
		} 
		$this->view->showPlanInmobiliaria ("plans.php" , $salidaInmo , $salidaPlanNuevo );
	}
	public function cambiarPlan()
	{
		require 'models/AdminModel.php';
        $modelU = new AdminModel(); 		

		$modelU->updatePlanInmobiliaria($_POST['nuevoplan'] , $_POST['inmobiliaria']) ;
		$this->view->showSuccess("success.php","Se actualizo correctamente");
	}
/* 	public function destacados()
	{
	$this->view->showPage("featured.php");
	} */
	public function deleteParLoca()
	{
		require 'models/AdminModel.php';
        $modeld = new AdminModel(); 
		if ($_POST['localidaddelete'] == '0')
			$modeld-> deletePartido($_POST['partidodelete'] ,  $_POST['provinciadelete']) ;
		else
			$modeld->deleteLocalidad($_POST['localidaddelete'], $_POST['partidodelete'] ,  $_POST['provinciadelete']) ; 
			
		$this->view->showSuccess("success.php","Se actualizo correctamente");
	
	}
	public function altaPartido()
	{
		require 'models/AdminModel.php';
        $modelP = new AdminModel(); 
		$modelP->insertPartido($_POST['partido'] , $_POST['provinciaCarga']  ) ;
		$this->view->showSuccess("success.php","Se actualizo correctamente");

	}
	public function altaLocalidad()
	{
		require 'models/AdminModel.php';
        $modelL = new AdminModel(); 
		


		$modelL->insertLocalidad($_POST['localidad'] , $_POST['partidoLocalidad'] , $_POST['provinciaLocalidad'] ) ;
		$this->view->showSuccess("success.php","Se actualizo correctamente");
	
		
		
	}
	
	public function altaLugares()
	{
		require 'models/AdminModel.php';
        $modell = new AdminModel(); 
		$provincia = $modell->getProvincias();
		$datap['provincias'] = $provincia ; 
		
		$this->view->showInitialRegister("locations.php" , $datap );
		
	}
	public function habilitarDestacado()
	{
		require 'models/AdminModel.php';
        $modelD = new AdminModel(); 
		$modelD->AltaDestacado($_POST['aviso']);
		$this->view->showSuccess("success.php","Se actualizo correctamente");
	}
	public function deshabilitarDestacado()
	{
		require 'models/AdminModel.php';
        $modelInd = new AdminModel(); 
		$modelInd->bajaDestacado($_POST['avisodestacado']);
		$this->view->showSuccess("success.php","Se actualizo correctamente");

	}
	public function estadoInmobiliaria()
	{
	    require 'models/AdminModel.php';
        $model = new AdminModel(); 	
		
		$model->setEstadoInmobiliaria( $_POST['inmobiliaria'], $_POST['habilitada'] ) ;

		$this->view->showSuccess("success.php", "Se actualizo correctamente ");
		
	}
	
	public function mostrarReporte()
	{
		$this->view->showPage("report.php");
	}

}
?>