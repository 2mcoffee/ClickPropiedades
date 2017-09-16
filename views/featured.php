<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
	    <script>
			$(document).ready(function(){
			$("#inmobiliaria").change(function() {
				
				var Idinmobiliaria  = $(this).val();
				if(Idinmobiliaria > 0)
				{
			        var datos = { Idinmobiliaria : $(this).val()   };
			        $.post("views/Avisos.php", datos, function(avisos) {
					  	var $comboAvisos = $("#aviso");
		                $comboAvisos.empty();
						$comboAvisos.append("<option value='0'>Avisos</option>");
		                $.each(avisos, function(index, aviso) {
	                        $comboAvisos.append("<option value=" + aviso.id + ">" + aviso.nombre + "</option>");
		                });
					}, 'json');
				}
				else
				{
					var $comboAvisos = $("#aviso");
	                $comboAvisos.empty();
					$comboAvisos.append("<option>Seleccione un aviso</option>");

				}
			});			
		}); 
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
			<h1>Habilitar Destacados</h1>
			<br>
			<form action="habilitarDestacado.php" method="post" name="frmEnable">
				<select name="inmobiliaria" size="1" id="inmobiliaria">
					<option value="0" selected="selected" disabled>Inmobiliarias</option>
					<?php echo $salidaInmoHab; ?>
				</select><br>
				<select name="aviso" size="1" id="aviso">
					<option value="0" selected="selected" disabled>Aviso</option>
					<?php echo $salidaAvisoHab; ?>
				</select><br>
				<input type="submit" value="Habilitar">
			</form>
		</div>
		<br>
		<br>
		<div class="login">
			<h1>Deshabilitar Destacados</h1>
			<br>
			<form action="deshabilitarDestacado.php" method="post" name="frmDisable">
				<select name="avisodestacado" size="1" id="avisodestacado">
					<option value="0" selected="selected" disabled>Inmobiliarias</option>
					<?php echo $salidaInmoDes; ?>
				</select><br>
				<input type="submit" value="Deshabilitar">
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