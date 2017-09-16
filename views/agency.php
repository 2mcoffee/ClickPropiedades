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
			<h1>Habilitar Inmobiliarias</h1>
			<br>
			<form action="habilitarInmobiliaria.php" method="post" name="frmEnable">
			
				<select name="inmobiliaria" size="1" id="inmobiliaria">
					<option value="0" selected="selected" disabled>Inmobiliarias</option>
					<?php  echo $salidaInmoDes ;?>
				</select><br>
				<input type="submit" value="Habilitar">
			</form>
		</div>
		<br>
		<br>
		<div class="login">
			<h1>Deshabilitar Inmobiliarias</h1>
			<br>
			<form action="deshabilitarInmobiliaria.php" method="post" name="frmDisable">
		
				<select name="inmobiliaria" size="1" id="inmobiliaria">
					<option value="0" selected="selected" disabled>Inmobiliarias</option>
					<?php  echo $salidaInmoHab ;?>
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