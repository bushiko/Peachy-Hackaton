<?php
	//Ejercicio 2
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('test');

	//Create & Populate table
	mysql_query("CREATE TABLE IF NOT EXISTS padre_hijo(padre VARCHAR(50), hijo VARCHAR(50),  PRIMARY KEY(padre, hijo))");
	mysql_query("INSERT IGNORE INTO padre_hijo VALUES
		('Juan', 'Pedro'), 
		('Pedro', 'Jesus'), 
		('Raul', 'Josue'),
		('Josue', 'Maria'),
		('Josue', 'Carlos')");



	//La siguiente consulta regresará la relación nieto-abuelo de los valores presentes en la tabla
	//Por ejemplo: Juan-Jesus, Raul-Maria, etc..
	$query = mysql_query("SELECT a.padre AS abuelo, b.hijo AS nieto FROM padre_hijo a INNER JOIN padre_hijo b ON a.hijo = b.padre");
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
				<h1>Ejercicio #2</h1>
				<?php
					if(mysql_num_rows($query)) {
					echo '<table class="table table-striped">'.
						'<th>Abuelo</th><th>Nieto</th>';
					while($relacion = mysql_fetch_array($query)) {
						echo 
						'<tr>'.
							'<td>'.$relacion['abuelo'].'</td><td>'.$relacion['nieto'].'</td>'.
						'</tr>';
					}
					echo '</table>';
					}
				?>
				</div>
			</div>
		</div>
	</body>
</html>