<?php
include 'includes/meta.php';
include 'includes/header.php';
require_once 'mobile/Mobile_Detect.php';
$detect = new Mobile_Detect;
?>
<table class="content">
	<tr>
		<td class="content left">
		<?php 
		if( !$detect->isMobile() && !$detect->isTablet() ){
			echo '<img src="./banners/izquierda.jpg" alt="Publicidad">';
		};
		?>
		</td>
		<td class="content central">
			<div class="search">
			<br>
			<form  action="SearchController.php" method="POST" >
				<table>
					<tr>
						<td><select name="edificacion" size="1" id="edificacion">
								<option value="0" selected="selected">Edificación</option>
								<?php  echo $salidaEdificaciones ;?>
							</select>
						</td>
					</tr>
					<tr>
						<td><select name="provincia" size="1" id="provincia">
								<option value="0" selected="selected">Provincia</option>
								<?php  echo $salidaProvincia ;?>
							</select>
						</td>
					</tr>
					<tr>
						<td><select name="partido" size="1" id="partido">
								<option value="0" selected="selected">Partido</option>
								<?php  echo $salidaPartido ;?>
							</select>
						</td>
					</tr>
					<tr>
						<td><select name="localidad" size="1" id="localidad">
								<option value="0" selected="selected">Localidad</option>
								<?php  echo $salidaLocalidad ;?>
							</select>
						</td>
					</tr>
					<tr>
						<td><select name="operacion" size="1" id="operacion">
								<option value="0" selected="selected">Operación</option>
								<?php  echo $salidaOperaciones ;?>
							</select>
						</td>
					</tr>
					<tr>
						<td><select name="ambientes" size="1" id="ambientes">
								<option value="0" selected="selected">Ambientes</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">+3</option>
							</select>
						</td>
					</tr>
					<tr>
					<td><input type="reset" value="Limpiar"> <input type="submit" value="Buscar"></td>
					</tr>
				</table>
			</form>
			</div>
			<div class="fix">
			</div>
			<?php
				$q = $vars['avisosCabecera'] ;
					while($cab = $q->fetch())
						{
							echo "<div class='mini'>";
							echo "<h1>".$cab['inmueble']." en ".$cab['operacion']."</h1>";
							echo "<h2>";
							if (empty($cab['fotoInmueble'])) {
								echo '<img src="./images/nodisponible.jpg" alt="Sin Imagen">';
							}
							else {
								echo "<img src='./uploads/".$cab['IdImobiliaria']."/".$cab['idAviso']."/".$cab['fotoInmueble']."' alt='".$cab['inmueble']."'>";
							}
							echo "<span>".utf8_encode($cab['localidad'])."<br>".$cab['provincia']."<br>";
							if (empty($cab['precio']) || $cab['precio'] == 0 || $cab['precio'] == 1) {
								echo "CONSULTAR<br><br>";
							}
							else {
								echo $cab['moneda']." ".$cab['precio']."<br><br>";
							}
							echo "<a href='DetailController.php?destino=".$cab['idAviso']."'>Ver Aviso</a></span>";
							echo "</h2>";
							echo "<h3><img src='./banners/mini".rand(1,8).".jpg' alt='banner'></h3>";							
							echo "</div>";
						};
			?>
			<br>
			<br>
			<!--<div class="publicidad"><img src="./banners/central.jpg" alt="Publicidad"></div>
			<br>-->
			<div class="featured">
				Emprendimientos
			</div>
			<div class="demo">
				<ul id="featured" class="content-slider">
					<?php
					$p = $vars['destacados'] ;
					 while($des = $p->fetch())
						 {
						 echo "<li> \n";		
							if (empty($des['foto'])) {
								echo "<h1><a href='DetailController.php?destino=".$des['idAviso']."'><img src='./images/nodisponible.jpg' alt='Sin Imagen'></a></h1> \n";
							}
							else {
								echo "<h1><a href='DetailController.php?destino=".$des['idAviso']."'><img src='./uploads/".$des['IdImobiliaria']."/".$des['idAviso']."/".$des['foto']."' alt='".$des['inmueble']."'></a></h1> \n";
							}
						 	echo "<h2>".$des['tipoInmueble']." | ".$des['tipoOperacion']."</h2> \n";
						 	echo "<h3>".utf8_encode($des['localidad'])."</h3> \n";
						 	echo "<h4>".$des['provincia']."</h4> \n";
							if (empty($des['precio']) || $des['precio'] == 0 || $des['precio'] == 1) {
								echo "<h5>CONSULTAR</h5> \n <br>";
							}
							else {
								echo "<h5>".$des['moneda']." ".$des['precio']."</h5> \n <br>";
							}														
							echo "<h6><a href='DetailController.php?destino=".$des['idAviso']."'>Ver Aviso</a></h6><br> \n";
						 echo "</li> \n";
						};
					?>
				</ul>
			</div>
			<br>
			<table class="random">
				<tr>
				<?php 
					$r = $vars['avisosFooter'] ;
					while($foo = $r->fetch())
						{
							echo "<td>";
							echo "<h1>".$foo['inmueble']." en ".$foo['operacion']."</h1>";
							echo "<h2>";
							if (empty($foo['fotoInmueble'])) {
								echo '<img src="./images/nodisponible.jpg" alt="Sin Imagen">';
							}
							else {
								echo "<img src='./uploads/".$foo['IdImobiliaria']."/".$foo['idAviso']."/".$foo['fotoInmueble']."' alt='".$foo['inmueble']."'>";
							}
							echo "<span>".utf8_encode($foo['localidad'])."<br>".$foo['provincia']."<br>";
							if (empty($foo['precio']) || $foo['precio'] == 0 || $foo['precio'] == 1) {
								echo "CONSULTAR<br><br>";
							}
							else {
								echo $foo['moneda']." ".$foo['precio']."<br><br>";
							}
							echo "<a href='DetailController.php?destino=".$foo['idAviso']."'>Ver Aviso</a><br><br></span>";
							echo "</h2>";
							echo "</td>";
						};
				?>
				</tr>	
			</table>
        </td>
		<td class="content right">
		<?php 
		if( !$detect->isMobile() && !$detect->isTablet() ){
		?>
		<div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-slides="> div"	data-cycle-timeout="3000">
			<?php include 'banners/newspaper.php'; ?>
		</div>
		<br>
		<img src="./banners/derecha.jpg" alt="Publicidad">
		<?php 
		};
		?>
		</td>
	</tr>
</table>
<?php 
if( $detect->isMobile() || $detect->isTablet() ){
	echo '<br>';
	echo '<div class="mobile">';
	echo '<img src="./banners/mobile.jpg" alt="Publicidad">';
	echo '</div>';
	echo '<br>';
};
?>
<?php
include 'includes/footer.php';
?>