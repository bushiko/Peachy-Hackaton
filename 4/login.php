<?php
	include('includes/application_top.php');

	if (isset($_POST['action']) && $_POST['action'] === 'process') {
		$error = false;

		$mail = $_POST['login_mail'];
		$password = $_POST['login_pass'];

		$user_query = mysql_query("SELECT * FROM users WHERE mail = '".$mail."'");

		if(mysql_num_rows($user_query) == 0) {
			$error = 'No existe tal usuario';
		} else {
			$user = mysql_fetch_array($user_query);
			if (PassHash::check_password($user['password'], $password)) {
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['stripe_customer_id'] = $user['stripe_customer_id'];
				header('Location: index.php');
			} else {
				$error = 'Contrase&ntilde;a Incorrecta';
			}
		}
	}

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
				<h2>Inicia sesi&oacute;n en tu cuenta</h2>
				<form name="login" action="login.php" method="POST">
					<input type="hidden" name="action" value="process">

					<?php if(isset($error) && $error != false) :?>
					<div class="alert alert-danger"><?= $error ?> </div>
					<?php endif; ?>

				  <div class="form-group">
				    <label for="login_mail">Email</label>
				    <input type="email" class="form-control" name="login_mail" placeholder="Enter email">
				  </div>
				  <div class="form-group">
				    <label for="login_pass">Password</label>
				    <input type="password" class="form-control" name="login_pass" placeholder="Password">
				  </div>
				  <button type="submit" class="btn btn-success">Iniciar Sesi&oacute;n</button>
				</form>
				</div>
			</div>
		</div>
	</body>
</html>