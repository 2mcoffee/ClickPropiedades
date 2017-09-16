<?php
class View
{
    function __construct()
    {
    }

    public function show($name, $vars = array())
    {

        $config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;

        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		
    /*     if(is_array($vars))
        {
                    foreach ($vars as $key => $value)
                    {
                    $key = $value;
                    }
                } */	
	$combo_provincias = $vars['provincias'] ;
	$salidaProvincia = null ;
	while($des = $combo_provincias->fetch() )
	{
		$salidaProvincia.= "<option value='".$des['id_provincia']."'>".$des['descripcion']."</option>";
	} 
	
	$combo_edificaciones = $vars['edificaciones']  ;
	$salidaEdificaciones = null ;
	while($cp = $combo_edificaciones->fetch() )
	{
		$salidaEdificaciones.= "<option value='".$cp['id_edificacion']."'>".$cp['edificacion']."</option>";
	} 
	
	$combo_operaciones = $vars['operaciones'] ;
	$salidaOperaciones = null ;
	while($ce = $combo_operaciones->fetch() )
	{
		$salidaOperaciones.= "<option value='".$ce['id_operacion']."'>".$ce['operacion']."</option>";
	} 
	
	
     include($path);
    }
	public function showAccesosAdmin($name, $vars = array())
	{
		/* $salidaInmoDes (sin activar) y un $salidaInmoHab */
	    $config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;

        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		
		$combo_habilitadas = $vars['InmobiliariasHabilitadas'] ;
		$salidaInmoHab = null ;
		while($ch = $combo_habilitadas->fetch() )
		{
			$salidaInmoHab.= "<option value='".$ch['id']."'>".$ch['nombre']."</option>";
			
		} 
		
		$combo_deshabilitadas = $vars['InmobiliariasDeshabilitadas'] ;
		$salidaInmoDes = null ;
		while($cd = $combo_deshabilitadas->fetch() )
		{
			$salidaInmoDes.= "<option value='".$cd['id']."'>".$cd['nombre']."</option>";
		} 
		
		include($path);
	  
	}
	public function showPublish($name ,  $vars = array())
	{
	        $config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;

        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		
	$combo_provincias = $vars['provincias'] ;
	$salidaProvincia = null ;
	while($des = $combo_provincias->fetch() )
	{
		$salidaProvincia.= "<option value='".$des['id_provincia']."'>".$des['descripcion']."</option>";
	} 
	
	$combo_edificaciones = $vars['edificaciones']  ;
	$salidaEdificaciones = null ;
	while($cp = $combo_edificaciones->fetch() )
	{
		$salidaEdificaciones.= "<option value='".$cp['id_edificacion']."'>".$cp['edificacion']."</option>";
	} 
	
	$combo_operaciones = $vars['operaciones'] ;
	$salidaOperaciones = null ;
	while($ce = $combo_operaciones->fetch() )
	{
		$salidaOperaciones.= "<option value='".$ce['id_operacion']."'>".$ce['operacion']."</option>";
	} 
	
	$combo_monedas = $vars['monedas'] ;
	$salidaMoneda = null ;
	while($cmonedas = $combo_monedas->fetch() )
	{
		$salidaMoneda.= "<option value='".$cmonedas['id_moneda']."'>".$cmonedas['moneda']."</option>";
	}
	
     include($path);		
	}
	
	public function showSearch($name, $vars = array())
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
	$combo_provincias = $vars['provincias'] ;		
	$salidaProvincia = null ;
	while($des = $combo_provincias->fetch() )
	{
		$salidaProvincia.= "<option value='".$des['id_provincia']."'>".$des['descripcion']."</option>";
	} 
	
	$combo_edificaciones = $vars['edificaciones']  ;
	$salidaEdificaciones = null ;
	while($cp = $combo_edificaciones->fetch() )
	{
		$salidaEdificaciones.= "<option value='".$cp['id_edificacion']."'>".$cp['edificacion']."</option>";
	} 
	
	$combo_operaciones = $vars['operaciones'] ;
	$salidaOperaciones = null ;
	while($ce = $combo_operaciones->fetch() )
	{
		$salidaOperaciones.= "<option value='".$ce['id_operacion']."'>".$ce['operacion']."</option>";
	} 	
	
		include($path);
	}
	public function showDetail($name, $vars = array())
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		include($path);
	}
	public function showInvalido($name, $mensaje)
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }

		
		include($path);
	}
	public function showInitialRegister($name ,$vars = array())
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		$combo_provincias = $vars['provincias'] ;
		$salidaProvincia = null ;
		while($des = $combo_provincias->fetch() )
		{
			$salidaProvincia.= "<option value='".$des['id_provincia']."'>".$des['descripcion']."</option>";
		} 
		/* $mensaje = $vars['mensaje'] ; */
		
		include($path);
	}
	
	public function showSuccess ($name , $mensaje)
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		include($path);
	}
	public function showPlanInmobiliaria ($name , $salidaInmo , $salidaPlanNuevo )
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		include($path);
	}
	public function showUser($name, $vars = array() , $id_user, $user )
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }

		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) 
		{
			session_unset();     
			session_destroy();   
			session_regenerate_id(true); 
		}

		$_SESSION['LAST_ACTIVITY'] = time(); 
		$_SESSION['User']= $user ;
		$_SESSION['IdUser']= $id_user ;
		

		include($path);
		
	}
	public function showAdmin($name , $id_user, $user )
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }

		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) 
		{
			session_unset();     
			session_destroy();   
			session_regenerate_id(true); 
		}

		$_SESSION['LAST_ACTIVITY'] = time(); 
		$_SESSION['User']= $user ;
		$_SESSION['IdUser']= $id_user ;
		

		include($path);
	}
	public function showPage($name)
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }

		include($path);
	}
	public function showPerfilUsuario($name, $objetos = array())
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		
		$combo_provincias = $objetos['provincias'] ;
		$salidaProvincia = null ;
	while($des = $combo_provincias->fetch() )
	{
		$salidaProvincia.= "<option value='".$des['id_provincia']."'>".$des['descripcion']."</option>";
	} 
		
		$objetoPerfil = $objetos['perfilUsuario'] ;

		while($arrayPerfil = $objetoPerfil->fetch() )
		{
		
			$salidarazonSocial = $arrayPerfil['razonSocial'] ;
			$salidacuit = $arrayPerfil['cuit'] ;
			$salidaasesorComercial = $arrayPerfil['asesorComercial'] ;
			$salidaregion = $arrayPerfil['region'] ;
			$salidanumero = $arrayPerfil['numero'] ;
			$salidamail = $arrayPerfil['mail'] ;
			$salidasite = $arrayPerfil['site'] ;
			$salidaIdProvincia = $arrayPerfil['IdProvincia'] ;
			$salidaprovincia = $arrayPerfil['provincia'] ;
			$salidaIdPartido = $arrayPerfil['IdPartido'] ;
			$salidapartido = $arrayPerfil['partido'] ;
			$salidaIdLocalidad = $arrayPerfil['IdLocalidad'] ;
			$salidalocalidad = $arrayPerfil['localidad'] ;
			$salidadireccion = $arrayPerfil['direccion'] ;
			$salidaaltura = $arrayPerfil['altura'] ;
			$salidapiso = $arrayPerfil['piso'] ;			
			$salidadepto = $arrayPerfil['depto'] ;						
			$salidaurl_log = $arrayPerfil['url_log'] ;	
			$salidaidInmobiliaria =  $arrayPerfil['idInmobiliaria'] ;	
		} 
		
		
		include($path);
	}
	public function showAvisotoEdit ($name, $objetos = array())
	{
		$config = Config::singleton();
        $path = $config->get('viewsFolder') . $name;
		
        if (file_exists($path) == false)
        {
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
		
		$combo_provincias = $objetos['provincias'] ;
		$salidaProvincia = null ;
	while($des = $combo_provincias->fetch() )
	{
		$salidaProvincia.= "<option value='".$des['id_provincia']."'>".$des['descripcion']."</option>";
	} 
		
	$combo_edificaciones = $objetos['edificaciones']  ;
	$salidaEdificaciones = null ;
	while($cp = $combo_edificaciones->fetch() )
	{
		$salidaEdificaciones.= "<option value='".$cp['id_edificacion']."'>".$cp['edificacion']."</option>";
	} 
	
	$combo_operaciones = $objetos['operaciones'] ;
	$salidaOperaciones = null ;
	while($ce = $combo_operaciones->fetch() )
	{
		$salidaOperaciones.= "<option value='".$ce['id_operacion']."'>".$ce['operacion']."</option>";
	} 
	
	$combo_monedas = $objetos['monedas'] ;
	$salidaMoneda = null ;
	while($cmonedas = $combo_monedas->fetch() )
	{
		$salidaMoneda.= "<option value='".$cmonedas['id_moneda']."'>".$cmonedas['moneda']."</option>";
	}
	
	$fotos  = $objetos['fotosAviso'] ;
	$cont = 1;
	while ($fotosAvi = $fotos->fetch() )
	{
		if ($cont == 1 )
			$salidaimagen1 = $fotosAvi['url'] ; 
		if ($cont == 2 )
			$salidaimagen2 = $fotosAvi['url'] ; 
		if ($cont == 3 )
			$salidaimagen3 = $fotosAvi['url'] ; 
		if ($cont == 4 )
			$salidaimagen4 = $fotosAvi['url'] ; 
		if ($cont == 5 )
			$salidaimagen5 = $fotosAvi['url'] ; 
		
		$cont = $cont  + 1 ;  
	}
		$objetoAvisotoEdit = $objetos['salidaAviso'] ;

		while($arrayAvisotoEdit = $objetoAvisotoEdit->fetch() )
		{
			$salidaoperacion = $arrayAvisotoEdit['operacion'] ;
			$salidatipoinmueble = $arrayAvisotoEdit['tipoinmueble'] ;
			$salidacodigoficha = $arrayAvisotoEdit['codigoficha'] ;
			$salidamoneda = $arrayAvisotoEdit['moneda'] ;
			$salidaprecio = $arrayAvisotoEdit['precio'] ;
			$salidaprovincia = $arrayAvisotoEdit['provincia'] ;
			$salidaIdProvincia  = $arrayAvisotoEdit['idprovincia'] ;
			$salidapartido = $arrayAvisotoEdit['partido'] ;
			$salidaIdPartido = $arrayAvisotoEdit['idpartido'] ;
			$salidalocalidad = $arrayAvisotoEdit['localidad'] ;
			$salidaIdLocalidad = $arrayAvisotoEdit['idlocalidad'] ;
			$salidacalle = $arrayAvisotoEdit['calle'] ;
			$salidaaltura = $arrayAvisotoEdit['altura'] ;
			$salidapiso = $arrayAvisotoEdit['piso'] ;
			$salidadepto = $arrayAvisotoEdit['depto'] ;
			$salidasuptotal = $arrayAvisotoEdit['suptotal'] ;
			$salidasupcubierta = $arrayAvisotoEdit['supcubierta'] ;			
			$salidaambientes = $arrayAvisotoEdit['ambientes'] ;						
			$salidadormitorios = $arrayAvisotoEdit['dormitorios'] ;	
			$salidabanos =  $arrayAvisotoEdit['banos'] ;	
			$salidatoilette =  $arrayAvisotoEdit['toilette'] ;	
			$salidaantiguedad =  $arrayAvisotoEdit['antiguedad'] ;	
			$salidaestado =  $arrayAvisotoEdit['estado'] ;	
			$salidaluminosidad =  $arrayAvisotoEdit['luminosidad'] ;	
			$salidaterraza =  $arrayAvisotoEdit['terraza'] ;	
			$salidabalcon =  $arrayAvisotoEdit['balcon'] ;	
			$salidapatio =  $arrayAvisotoEdit['patio'] ;	
			$salidapileta =  $arrayAvisotoEdit['pileta'] ;	
			$salidajardin =  $arrayAvisotoEdit['jardin'] ;	
			$salidagarage =  $arrayAvisotoEdit['garage'] ;	
			$salidaseguridad  =  $arrayAvisotoEdit['seguridad'] ;	
			$salidaprofesional =  $arrayAvisotoEdit['profesional'] ;	
			$salidadescripcion =  $arrayAvisotoEdit['descripcion'] ;	
			$salidaidimobiliaria =  $arrayAvisotoEdit['idimobiliaria'] ;
			$salidaidaviso =  $arrayAvisotoEdit['idaviso'] ;
			$salidaidtipoinmueble =  $arrayAvisotoEdit['idtipoinmueble'] ;
			$salidaidoperacion = $arrayAvisotoEdit['idtipooperacion'] ;
			$salidaidmoneda = $arrayAvisotoEdit['idtipomoneda'] ;
		} 
		include($path);
	}
}


?>