<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
ob_start();

/***** Parametria *****/
$DB_Server = "localhost"; // Servidor MySQL
$DB_Username = "revistac_db"; // Usuario
$DB_Password = "C0mpuca5as"; // Password
$DB_DBName = "revistac_db"; // Base de datos
$xls_filename = 'VisitasAvisos_'.date('Y-m-d').'.xls'; // Nombre de Archivo
 
/***** NO EDITAR *****/
// Crear conexion con MySQL
$sql = "select avi.id_aviso as idAviso , inmo.nombre as Inmobiliaria,  ti.descripcion as Inmueble ,  toper.descripcion as  Operacion ,  loca.descripcion as Localidad , tm.descripcion as Moneda , db.precio as Precio , va.fecha_visita as Visita  FROM inmobiliarias inmo inner join avisos avi on avi.id_inmobiliaria = inmo.id_inmobiliaria  inner join  localidades loca on avi.id_localidad = loca.id_localidad inner join datos_basicos db on avi.id_dato_basico = db.id_dato_basico  inner join  tipo_operaciones toper on db.id_tipo_operacion = toper.id_tipo_operacion inner join tipo_inmuebles ti on db.id_tipo_inmueble = ti.id_tipo_inmueble inner join tipo_monedas tm on tm.id_tipo_moneda = db.id_tipo_moneda 
inner join visitas_avisos va on va.id_aviso = avi.id_aviso
WHERE inmo.habilitada = 1 order by inmo.id_inmobiliaria , avi.id_aviso , va.fecha_visita";
$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Error al conectar con MySQL:<br />" . mysql_error() . "<br />" . mysql_errno());
// Seleccionar Base de datos
$Db = @mysql_select_db($DB_DBName, $Connect) or die("Error al seleccionar la base de datos:<br />" . mysql_error(). "<br />" . mysql_errno());
// Ejecutar query
$result = @mysql_query($sql,$Connect) or die("Error al ejecutar el query:<br />" . mysql_error(). "<br />" . mysql_errno());
 
// Informacion para header
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$xls_filename");
header('Cache-Control: max-age=0');
header("Pragma: no-cache");
header("Expires: 0");
 
/***** Formateo para excel *****/
// Definir separadores
$sep = "\t";
 
// Impresion de nombres de columnas
for ($i = 0; $i<mysql_num_fields($result); $i++) {
  echo mysql_field_name($result, $i) . "\t";
}
print("\n");
 
// Loop de obtencion de datos
while($row = mysql_fetch_row($result))
{
  $schema_insert = "";
  for($j=0; $j<mysql_num_fields($result); $j++)
  {
    if(!isset($row[$j])) {
      $schema_insert .= "NULL".$sep;
    }
    elseif ($row[$j] != "") {
      $schema_insert .= "$row[$j]".$sep;
    }
    else {
      $schema_insert .= "".$sep;
    }
  }
  /*  $schema_insert = str_replace($sep."$", "Pesos", $schema_insert);  */
  $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
  $schema_insert .= "\t";
  print(trim($schema_insert));
  print "\n";
}
?>