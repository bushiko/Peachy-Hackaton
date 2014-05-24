<!DOCTYPE html>
<html>
	<head>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
				<h1>Ejercicio #1</h1>
				<?php
					//Ejercicio 1
					echo '<table class="table table-striped">'.
						'<th>Contador</th><th>Resultado</th>';
					for($i = 1, $n = 100; $i<=$n; $i++) {
						echo '<tr><td>'.$i.'</td><td>';
						echo ( $i%2 === 0 
							? 'Fizz'  
							: ($i%7 === 0
								? 'FizzBuzz'
								: 'Buzz') ).'</td></tr>';
					}
					echo '</table>';
				?>

				</div>
			</div>
		</div>
	</body>
</html>