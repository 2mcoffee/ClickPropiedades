<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>341</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	    <script>
			$(document).ready(function(){
			$("#cboProvincia").change(function() {
				var provincia = $(this).val();
				if(provincia > 0)
				{
			        var datos = { idProvincia : $(this).val()   };

			        $.post("views/Partidos.php", datos, function(partidos) {
					
						var $comboLocalidades = $("#cboLocalidades");
						$comboLocalidades.empty() ;
						$comboLocalidades.append("<option>Seleccione una Localidad</option>");
					
					  	var $comboPartidos = $("#cboPartidos");
		                $comboPartidos.empty();
						$comboPartidos.append("<option value='0'>Partidos</option>");
		                $.each(partidos, function(index, partido) {
	                        $comboPartidos.append("<option value=" + partido.id + ">" + partido.nombre + "</option>");
		                });
					}, 'json');
				}
				else
				{
					var $comboPartidos = $("#cboPartidos");
	                $comboPartidos.empty();
					$comboPartidos.append("<option>Seleccione un partido</option>");
					
					var $comboLocalidades = $("#cboLocalidades");
					$comboLocalidades.empty() ;
					$comboLocalidades.append("<option>Seleccione una Localidad</option>");
				}
			});
			
			$("#cboPartidos").change(function(){
				var  partido = $(this).val();
				if(partido > 0)
				{
			        var datos = { idPartido : $(this).val()   };
			        $.post("views/Localidades.php", datos, function(localidades) {
					  	var $comboLocalidades = $("#cboLocalidades");
		                $comboLocalidades.empty();
						$comboLocalidades.append("<option value='0'>Localidades</option>");
		                $.each(localidades, function(index, localidad ) {
	                        $comboLocalidades.append("<option value=" + localidad.id + ">" + localidad.nombre + "</option>");
		                });
					}, 'json');
				}
				else
				{
					var $comboLocalidades = $("#cboLocalidades");
	                $comboLocalidades.empty();
					$comboLocalidades.append("<option>Seleccione una Localidad </option>");
				}
			
			} ) ;
			
			
		}); 
        </script>
</head>
<body>
<div class="divContenedor">
		<h2>Combos  anidados</h2>
		<div class="divLabels">
			<label for="cboProvincia">Provincia</label>
		</div>
		<div class="divSelects">
			<select id="cboProvincia" name="cboProvincia" >
				<option value="0">Seleccione un provincia</option>
				<?php  echo $salidaProvincia ;?>
			</select>
		</div>
		<div class="divLabels">
			<label for="cboPartidos">Partidos</label>
		</div>
		<div class="divSelects">
			<select id="cboPartidos" >
				<option value="0">Seleccione un Partido</option>
			</select>
		</div>
		<div class="divLabels">
			<label for="cboLocalidades">Localidades</label>
		</div>
		<div class="divSelects">
			<select id="cboLocalidades" >
				<option value="0">Seleccione una Localidad</option>
			</select>
		</div>
	</div>	


<table>
    <tr>
        <th>ID
        </th><th>Item
    </th>
    </tr>
    <?php
    
	// $usuarios =$vars['usuarios'] ;
	// while($item = $usuarios->fetch(PDO::FETCH_ORI_NEXT))
	// {
	// echo $item['usuario'] ;
	// }
	
	
	// $destacados = $vars['destacados'] ;

	// while($des = $destacados->fetch(PDO::FETCH_ORI_NEXT))
		// {
		// echo $des['url_log'] ;
	// }
	
	/*
	$obj = json_decode($json_destacodo);
	foreach ($obj as List($valor) ) 
	{
	echo $valor->{'inmobiliaria'}; 
	} 
	*/
	
	 $p = $vars['destacados'] ;
	 while($des = $p->fetch())
		 {
		echo $des['inmobiliaria'] ; echo " - " ; echo $des['foto'] ; echo " - " ; echo $des['tipoInmueble'] ; echo " - " ; echo $des['localidad'] ; 
		 echo " - " ; echo $des['tipoOperacion'] ;echo " - " ; echo $des['precio'] ;echo " - " ; echo $des['moneda'] ;	echo " - || - " ; echo  $des['provincia'] ;
	 }

    ?>

</table>


</body>
</html>