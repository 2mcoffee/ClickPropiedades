<?php
    header("Content-Type: application/rss+xml; charset=ISO-8859-1");
 
    DEFINE ('DB_USER', 'revistac_feed');   
    DEFINE ('DB_PASSWORD', 'click2017');   
    DEFINE ('DB_HOST', 'localhost');   
    DEFINE ('DB_NAME', 'revistac_db');
 
    $rssfeed = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>'."\n";
    $rssfeed .= '<rss version="2.0">'."\n";
    $rssfeed .= '	<channel>'."\n";
    $rssfeed .= '		<title>ClickPropiedades.com</title>'."\n";
	$rssfeed .= '		<description>Propiedades e Inmuebles en Venta y Alquiler</description>'."\n";
	$rssfeed .= '		<lastBuildDate>' . date("D, d M Y G:i:s O") . '</lastBuildDate>'."\n";
    $rssfeed .= '		<link>http://clickpropiedades.com/</link>'."\n";
    
 
    $connection = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
        or die('Error: No se logro conexion al servidor');
    mysql_select_db(DB_NAME)
        or die ('Error: No se logro conexion a la base de datos');
 
    $query = "SELECT  
				CASE
					WHEN C.descripcion = 'DEPARTAMENTOS' THEN CONCAT('Departamento en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'CASAS' THEN CONCAT('Casa en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'PH' THEN CONCAT('PH en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'QUINTAS' THEN CONCAT('Quinta en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'LOTES' THEN CONCAT('Lote en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'CAMPOS' THEN CONCAT('Campo en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'CHACRAS' THEN CONCAT('Chacra en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'GALPONES' THEN CONCAT('Galpon en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'LOCALES' THEN CONCAT('Local en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'OFICINAS' THEN CONCAT('Oficina en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'CONSULTORIOS' THEN CONCAT('Consultorio en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'CHALETS' THEN CONCAT('Chalet en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'DUPLEX' THEN CONCAT('Duplex en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'TRIPLEX' THEN CONCAT('Triplex en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'MULTIFAMILIAR' THEN CONCAT('Multifamiliar en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'EMPRENDIMIENTOS' THEN CONCAT('Emprendimiento en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'FONDO DE COMERCIO' THEN CONCAT('Fondo de comercio en venta en ', LOWER(E.descripcion))
					WHEN C.descripcion = 'COCHERAS' THEN CONCAT('Cochera en venta en ', LOWER(E.descripcion))
				END as titulo,
				CONCAT('http://clickpropiedades.com/DetailController.php?destino=',A.id_aviso) as link, 
				A.descripcion as descripcion,
				A.fecha_alta as fecha
			FROM avisos as A
			INNER JOIN datos_basicos as B
				ON A.id_dato_basico = B.id_dato_basico
			INNER JOIN tipo_inmuebles C
				ON C.id_tipo_inmueble = B.id_tipo_inmueble
			INNER JOIN tipo_operaciones D 
				ON D.id_tipo_operacion = B.id_tipo_operacion
			INNER JOIN localidades E
				ON E.id_localidad = A.id_localidad
			WHERE D.id_tipo_operacion = 1 && A.fecha_alta BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
			ORDER BY A.fecha_alta DESC";

    $result = mysql_query($query) or die ("Error: No se logro ejecutar el query");
 
    while($row = mysql_fetch_array($result)) {
        extract($row);
 
        $rssfeed .= '		<item>'."\n";
        $rssfeed .= '			<title>' . $titulo . '</title>'."\n";
        $rssfeed .= '			<description>' . filter_var($descripcion, FILTER_SANITIZE_STRING,FILTER_SANITIZE_STRING) . '</description>'."\n";
        $rssfeed .= '			<link>' . $link . '</link>'."\n";
        $rssfeed .= '			<pubDate>' . date("D, d M Y H:i:s O", strtotime($fecha)) . '</pubDate>'."\n";
        $rssfeed .= '		</item>'."\n";
    }
 
    $rssfeed .= '	</channel>'."\n";
    $rssfeed .= '</rss>'."\n";
 
    file_put_contents("feed.xml", $rssfeed);
	header("Location: ./feed.xml");

?>