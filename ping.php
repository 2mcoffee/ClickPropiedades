    <?php
	
	/*Nombre Aplicacion*/
	echo 'Aplicacion: ClickPropiedades.com <br>';
	
	/*Versión Aplicacion*/
	echo 'Version Aplicacion: 1.0.0 <br>';

    /*Funcion Ping*/
    function ping($host)
    {
            exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
            return $rval === 0;
    }

    /*Chequeo Status del Host*/
    $host = 'www.clickpropiedades.com';
    $up = ping($host);

    /*Informo estado del servidor*/
    echo 'Estado Servidor: <img src="./images/panel/'.($up ? 'up-icon' : 'down-icon').'.png" alt="'.($up ? 'up' : 'down').'" /><br>';

	/*IP Servidor*/
	$localIP = getHostByName(getHostName());
	echo 'IP Servidor: '.$localIP.'<br>';
	
	/*Sistema Operativo*/
	echo 'SO Servidor: '.PHP_OS.'<br>';

	/*Version PHP*/
	echo 'Version PHP: ' . phpversion().'<br>';
	
	/*Conexion a la base de datos*/
	$conn = mysql_connect('localhost', 'revistac_db', 'C0mpuca5as');
	$db   = mysql_select_db('revistac_db');
	
	/*Informo estado del servidor MySQL*/
	echo 'Estado MySQL: <img src="./images/panel/'.(@mysql_ping() ? 'up-icon' : 'down-icon').'.png" alt="'.(@mysql_ping() ? 'up' : 'down').'" /><br>';
	
	/*Version MySQL*/
	if ($conn) {
		printf("Version MySQL: %s\n", mysql_get_server_info());
		echo '<br>';
	}
	
    ?>