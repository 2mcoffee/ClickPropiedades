<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
<!--Llenado de Combos-->
<script type="text/javascript">
$(document).ready(function() 
{
	$("#provinciaLocalidad").change(function() {
		var provincia = $(this).val();
		 
				if(provincia > 0)
				{
			        var datos = { idProvincia : $(this).val()   };
					
			        $.post("views/Partidos.php", datos, function(partidos) {
					  	var $combopartido = $("#partidoLocalidad");
		                $combopartido.empty();
						$combopartido.append("<option value='0'>Partido</option>");
		                $.each(partidos, function(index, partido) {
	                        $combopartido.append("<option value=" + partido.id + ">" + partido.nombre + "</option>");
		                   });
					}, 'json');
				}
				else
				{
					
					var $combopartido = $("#partidoLocalidad");
					$combopartido.empty() ;
					$combopartido.append("<option value ='0'>Partido</option>");
				}
			});			
}
		
		) 
;
</script>
<script type="text/javascript">
$(document).ready(function() 
{
	$("#provinciadelete").change(function() {
		var provincia = $(this).val();
		 
				if(provincia > 0)
				{
			        var datos = { idProvincia : $(this).val()   };
					
			        $.post("views/Partidos.php", datos, function(partidos) {
					  	var $combopartido = $("#partidodelete");
		                $combopartido.empty();
						$combopartido.append("<option value='0'>Partido</option>");
		                $.each(partidos, function(index, partido) {
	                        $combopartido.append("<option value=" + partido.id + ">" + partido.nombre + "</option>");
		                   });
					}, 'json');
				}
				else
				{
					
					var $combopartido = $("#partidodelete");
					$combopartido.empty() ;
					$combopartido.append("<option value ='0'>Partido</option>");
				}
			});			
}
		
		) 
;
</script>
<script type="text/javascript">
$(document).ready(function() 
{
$("#partidodelete").change(function() {
 
	var partido = $(this).val();
				if(partido > 0)
				{
			        var datos = { idPartido : $(this).val()   };
			        $.post("views/Localidades.php", datos, function(localidades) {
					  	var $combolocalidad = $("#localidaddelete");
		                $combolocalidad.empty();
						$combolocalidad.append("<option value='0'>Localidad</option>");
		                $.each(localidades, function(index, localidad) {
	                        $combolocalidad.append("<option value=" + localidad.id + ">" + localidad.nombre + "</option>");
		                   });
					}, 'json');
				}
				else
				{
					
					var $combolocalidad = $("#localidaddelete");
					$combolocalidad.empty() ;
					$combolocalidad.append("<option value ='0'>Localidad</option>");
				}
			});
} ) ;			
</script>


<table class="content">
	<tr>
		<td class="content left">
		<?php
		include 'includes/menu_admin.php';
		?>
		<br>
		<br>
		</td>
		<td class="content central">
		<div class="login">
			<h1>Cargar Partido</h1>
			<br>
			<form action="altaPartido.php" method="post" name="frmPartidos">
				<select name="provinciaCarga" size="1" id="provinciaCarga">
					<option value="0" selected="selected" disabled>Provincia</option>
					<?php echo $salidaProvincia; ?>
				</select><br>
				<input type="text" name="partido" placeholder="Partido">
				<br>
				<input type="submit" value="Cargar">
			</form>
		</div>
		<br>
		<br>
		<div class="login">
			<h1>Cargar Localidad</h1>
			<br>
			<form action="altaLocalidad.php" method="post" name="frmLocalidad">
				<select name="provinciaLocalidad" size="1" id="provinciaLocalidad">
					<option value="0" selected="selected" disabled>Provincia</option>
					<?php echo $salidaProvincia; ?>
				</select><br>
				<select name="partidoLocalidad" size="1" id="partidoLocalidad">
					<option value="0" selected="selected" disabled>Partido</option>
					<?php echo $salidaPartido; ?>
				</select><br>
				<input type="text" name="localidad" placeholder="Localidad">
				<br>
				<input type="submit" value="Cargar">
			</form>
		</div>
		<br>
		<br>
		<div class="login">
			<h1>Eliminar Partido ó Localidad</h1>
			<br>
			<form action="deleteParLoca.php" method="post" name="frmLocalidad">
				<select name="provinciadelete" size="1" id="provinciadelete">
					<option value="0" selected="selected" disabled>Provincia</option>
					<?php echo $salidaProvincia; ?>
				</select><br>
				<select name="partidodelete" size="1" id="partidodelete">
					<option value="0" selected="selected" disabled>Partido</option>
					<?php echo $salidaPartido; ?>
				</select><br>
				<select name="localidaddelete" size="1" id="localidaddelete">
					<option value="0" selected="selected" disabled>Localidad</option>
					<?php echo $salidaLocalidad; ?>
				</select><br>
				<input type="submit" value="Eliminar" onclick="return confirm('Si no ha seleccionado una localidad, se eliminará el partido y todas las localidades asociadas a él. ¿Desea continuar?');">
			</form>
		</div>
		<br>
        </td>
		<td class="content right">	
		</td>
	</tr>
</table>
<?php
include 'includes/footer.php';
?>