<br>
<table class="footer">
	<tr>
		<td>
			<h1>
			ClickPropiedades.com <span>| Propiedades e Inmuebles en Venta y Alquiler.</span>
			</h1>
			<span>
			El uso de este sitio web implica la aceptación de los <a href="./conditions.php">Términos y Condiciones</a> y la <a href="./privacy.php">Política de Privacidad</a>.
			</span>
			<br>
			© <?php date_default_timezone_set('America/Argentina/Buenos_Aires'); echo date("Y"); ?> | Todos los derechos reservados.
		</td>
		<td class="fnav">
		<div>
		<?php
			$page=basename($_SERVER['PHP_SELF']);
			if ($page!='index.php') {
    		echo "<a href='../test'>Inicio</a> | ";
			};
		?>
		<a href="./login.php">Ingresar</a> | <a href="./register.php">Registrarse</a> | <a href="./publish.php">Publicar</a> | <a href="./contact.php">Contacto</a>
		</div>
		<br>
		<div class="grayscale">Sitio desarrollado por <a href="http://twitter.com/2mcarg" target="_blank"><img src="./images/2mc_badge.png" alt="Too Much Coffee"></a> Too Much Coffee.</div>
		</td>
	</tr>
</table>

</body>

</html>
