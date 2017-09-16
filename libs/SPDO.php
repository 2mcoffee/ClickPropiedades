<?php
class SPDO extends PDO
{
    private static $instance = null;

    public function __construct()
    {

        $config = Config::singleton();
	   parent::__construct('mysql:host=' . $config->get('dbhost') . ';dbname=' . $config->get('dbname'),$config->get('dbuser'), $config->get('dbpass'));

    }



    public static function singleton()
    {
        if( self::$instance == null )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

function obtenerConexion() {
		
		//$db = new mysqli( 'localhost' , 'root' , '', 'mvc' );
		$db = new mysqli( 'localhost' , 'revistac_db' , 'C0mpuca5as', 'revistac_db' );
		
		$db->set_charset("utf8");
		
		if($db->connect_errno > 0){
		    die('Unable to connect to database [' . $db->connect_error . ']');
                    echo     $db->connect_error ;
		}

		return $db;	
	}

	function cerrarConexion($db, $query) {
		$query->free();
		$db->close();
	}

	function ejecutarQuery($db, $sql) {
		if(!$resultado = $db->query($sql)){
		    die('There was an error running the query [' . $db->error . ']');
		}

		return $resultado;
	}


	
	
	
?>