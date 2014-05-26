<?php
	include('includes/application_top.php');

	if(!isset($_SESSION['user_id'])) 
		header('Location: login.php');

	$user_id = $_SESSION['user_id'];
	$stripe_customer_id = $_SESSION['stripe_customer_id'];

	$subscriptions_query = mysql_query("SELECT s.stripe_subscription_id, s.stripe_card_id, s.product_id, ab.* FROM subscriptions s, address_book ab WHERE ab.user_id = s.user_id AND s.user_id = '".$user_id."'");
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
					<?php while($subscription = mysql_fetch_array($subscriptions_query)) : 
						$sub_info = Stripe_Customer::retrieve($stripe_customer_id)->subscriptions->retrieve($subscription['stripe_subscription_id']); 
						$card_info = Stripe_Customer::retrieve($stripe_customer_id)->cards->retrieve($subscription['stripe_card_id']);
					?>
						
				 		<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"> <?= $sub_info->plan->name ?> </h3>
							</div>
							<div class="panel-body">
								<p>Tarjeta Relacionada: <?= $card_info['type'].'-'.$card_info['last4'] ?></p>
								<p>Aparecer&aacute; en tu factura como: <?= $sub_info->plan->statement_description ?></p>
								<p>DIRECCI&Oacute;N</p>
								<ul>
									<li>Calle: <?= $subscription['calle'] ?></li>
									<li>Colonia: <?= $subscription['colonia'] ?></li>
									<li>Ciudad: <?= $subscription['ciudad'] ?></li>
									<li>C&oacute;digo Postal: <?= $subscription['codigo_postal'] ?></li>
								</ul>
							</div>
						</div> 

					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</body>
</html>