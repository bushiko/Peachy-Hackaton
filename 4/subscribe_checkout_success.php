<?php
	include('includes/application_top.php');

	if(!isset($_SESSION['checkout_success'])) 
		header('Location: index.php');

	if(!isset($_SESSION['user_id'])) 
		header('Location: login.php');

	$user_id = $_SESSION['user_id'];
	$user_query = mysql_query("SELECT mail, username from users where id='".$user_id."'");
	$user = mysql_fetch_array($user_query);
	$user_mail = $user['mail'];
	$user_name = $user['username'];

	//Let's subscribe to MailChimp
	$result = $MailChimp->call('lists/subscribe', array(
				'id'                => MAILCHIMP_LIST_ID,
				'email'             => array('email'=> $user_mail),
				'merge_vars'        => array('FNAME'=> $user_name, 'LNAME'=>''),
				'double_optin'      => false,
				'update_existing'   => true,
				'replace_interests' => false,
				'send_welcome'      => true,
			));

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
				<h2>FELICIDADES!</h2>
				<p>Te has suscrito correctamente al producto <?php echo $_SESSION['checkout_success']; unset($_SESSION['checkout_success']); ?></p>
				<p>Puedes ver tus suscripciones en la secci&oacute;n "Mi cuenta"</p>
				</div>
			</div>
		</div>
	</body>
</html>