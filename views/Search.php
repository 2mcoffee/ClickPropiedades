<?php
include 'includes/meta.php';
include 'includes/header.php';
?>
<table class="content">
	<tr>
		<td class="content left">
		<div class="summary">
		<h1>Filtros</h1>
		<?php
		$sf = $vars['salidaFiltros'];
			foreach($sf as $x => $x_value) {
			    echo "<h2>● ".$x.": ".utf8_encode($x_value)."</h2>";
			}
    	?>
		</div>
		<br>
		<div class="filter">
		Edificación<a href="#" id="itemsEdificacion"><img src="./images/arrow.png" alt="arrow"></a>
		</div>
		<div class="itemsEdificacion">
		<?php
		$fe = $vars['salidaFiltroEdificacion'] ;
	 		while($sfe = $fe->fetch()) {
			 echo "<h1>".$sfe['inmueble']." (".$sfe['total'].")</h1> \n";
	 		}
		?>
		</div>
		<br>
		<div class="filter">
		Localidad<a href="#" id="itemsLocalidad"><img src="./images/arrow.png" alt="arrow"></a>
		</div>
		<div class="itemsLocalidad">
		<?php
		$fl = $vars['salidaFiltroLocalidad'] ;
	 		while($sfl = $fl->fetch()) {
			 echo "<h1>".utf8_encode($sfl['localidad'])." (".$sfl['total'].")</h1> \n";
	 		}
		?>
		</div>
		<br>
		<div class="filter">
		Operación<a href="#" id="itemsOperacion"><img src="./images/arrow.png" alt="arrow"></a>
		</div>
		<div class="itemsOperacion">
		<?php
		$fo = $vars['salidaFiltroOperacion'] ;
	 		while($sfo = $fo->fetch()) {
			 echo "<h1>".$sfo['operacion']." (".$sfo['total'].")</h1> \n";
	 		}
		?>
		</div>
		<br>
		<div class="filter">
		Moneda<a href="#" id="itemsMoneda"><img src="./images/arrow.png" alt="arrow"></a>
		</div>
		<div class="itemsMoneda">
		<?php
		$fm = $vars['salidaFiltroMoneda'] ;
	 		while($sfm = $fm->fetch()) {
			 echo "<h1>".$sfm['moneda']." (".$sfm['total'].")</h1> \n";
	 		}
		?>
		</div>
		<br>
		<?php
		include 'includes/minisearch.php';
		?>
		<br>
		</td>
		<td class="content central">
		<table class="gridview">
				<?php
					$c = $vars['salidaCentral'];
					while($central = $c->fetch())
					{
						echo "<tr>";
						echo "<td>";
						echo "<div class='wrapper'>";
						if ($central['destacados'] == 1) {
							echo "<div class='ribbon-wrapper-green'><div class='ribbon-green'>Destacado</div></div>";
						};
						if (empty($central['fotoInmueble'])) {
							echo '<div class="gridimg"><img src="./images/nodisponible.jpg" alt="Sin Imagen"></div>';
						}
						else {
							echo "<div class='gridimg'><img src='./uploads/".$central['IdImobiliaria']."/".$central['idAviso']."/".$central['fotoInmueble']."' alt='".$central['inmueble']."'></div>";
						}
						echo "<div class='gridinfo'>";
						if (empty($central['fotoInmobiliaria'])) {
							echo '<img src="./images/nodisponible_inmo.jpg" alt="Sin Imagen">';
						}
						else {
							echo "<img src='./uploads/".$central['IdImobiliaria']."/".$central['fotoInmobiliaria']."' alt='Inmobiliaria'>";
						}
						echo "<a href='DetailController.php?destino=".$central['idAviso']."'>";
						echo "<h1>".$central['inmueble']." en ".utf8_encode($central['localidad'])." / ".$central['provincia']."</h1>";
						echo "</a>";
						echo "● Dirección: ".$central['calleAviso']." ".$central['alturaAviso']." ".$central['pisoAviso']."<br>";
						echo "● Tipo de Operación: ".$central['operacion']."<br>";
						if (empty($central['precio']) || $central['precio'] == 0 || $central['precio'] == 1) {
							echo "● Precio: CONSULTAR <br>";
						}
						else {
							echo "● Precio: ".$central['moneda']." ".$central['precio']."<br>";
						}
						echo "● Comercializado por: ".$central['NombreInmobiliaria']."<br>";
						echo "<br>";
						if (empty($central['descripcion'])) {
							echo "● Descripción: <br> Aviso sin descripción. <br>";
						}
						else {
							echo "● Descripción: <br>".substr($central['descripcion'],0,140)."... <br>";
						}
						echo "<br>";
						echo "</div>";
						echo "</div>";
						echo "</td>";
						echo "</tr> \n";
					};
				?>
		</table>
		<br>
		<div class="pagination">
		<?php
			$FiltrosAplicados = $vars['salidaFiltrosAplicados'];
			foreach($FiltrosAplicados as $obj => $value) {
				$get_x_Id .= "&". $obj."=".$value ;
			}
			$d = $vars['salidaTotalRegistros'];
			while($total = $d->fetch()) {
				$total_records = $total['totalRegistros'];
				$total_pages = ceil($total_records / 20);
					  
				for ($i=1; $i<=$total_pages; $i++) { 
					echo "<span><a href='SearchController.php?page=".$i.$get_x_Id."'>".$i."</a></span> "; 
				};
		};
		?>
		</div>
        </td>
		<td class="content right">	
		</td>
	</tr>
</table>
<?php
include 'includes/footer.php';
?>