<?php
	include('includes/application_top.php');

	if(!isset($_SESSION['user_id'])) 
		header('Location: login.php');


?>
<!DOCTYPE html>
<html>
	<head>
		<?php require(DIR_MODULES.'head_includes.php'); ?>

	</head>
	<body>
		<?php require(DIR_MODULES.'navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<ul>
						<li><a href="my_subscriptions.php">Mis Suscripciones</a></li>
						<li><a href="my_cards.php">Mis Tarjetas</a></li>
						<li><a href="#">Mis Direcciones</a></li>
						<li><a href="#">Mi Cuenta</a></li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>