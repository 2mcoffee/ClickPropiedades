<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
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
			<h1>Actualización de Plan</h1>
			<br>
			<form action="updatePlanInmo.php" method="post" name="frmPlans">
			
				<select name="inmobiliaria" size="1" id="inmobiliaria">
					<option value="0" selected="selected" disabled>Inmobiliarias</option>
					<?php  echo $salidaInmo; ?>
				</select><br> 
				<select name="nuevoplan" size="1" id="nuevoplan">
					<option value="0" selected="selected" disabled>Nuevo Plan</option>
					<?php  echo $salidaPlanNuevo; ?>
				</select><br>
				<input type="submit" value="Actualizar">
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