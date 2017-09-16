	<div class="minisearch">
		<h1>Buscador</h1>
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
								<?php  echo $salidaPartido; ?>
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
					<td><input type="submit" value="Buscar"></td>
					</tr>
				</table>
			</form>
		<br>
	</div>