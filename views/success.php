<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
<table class="content">
	<tr>
		<td class="content left">
		</td>
		<td class="content central">
			<br>
			<div class="login">
			<h1>Aviso al Usuario</h1>
			<br>
			<span><?php echo $mensaje; ?>.</span>
			<br><br>
			<input type="button" value="Volver" onClick="history.go(-1);">
			<br>
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