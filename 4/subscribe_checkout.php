<?php

include('includes/application_top.php');

if(!isset($_SESSION['user_id']))
	header('Location: login.php');

if(!isset($_GET['product_id']))
	header('Location: index.php');

$product_id = $_GET['product_id'];
$user_id = $_SESSION['user_id'];
$stripe_customer_id = $_SESSION['stripe_customer_id'];



$payment_query = mysql_query("SELECT * FROM cards_book WHERE user_id = '".$user_id."'");
$addresses_query = mysql_query("SELECT * FROM address_book WHERE user_id = '".$user_id."'");


$product_info_query = mysql_query("SELECT * FROM products WHERE id = '".$product_id."'");
$product_info = mysql_fetch_array($product_info_query);


if(isset($_POST['action']) && $_POST['action'] === 'process') {

	$card_id = $_POST['card_id'];
	$address_id = $_POST['address_id'];

	$stripe_plan = $product_info['stripe_plan_id'];
	$new_subscription = Stripe_Customer::retrieve($stripe_customer_id)->subscriptions->create(array("plan" => $stripe_plan));

	mysql_query("INSERT INTO subscriptions(stripe_subscription_id, stripe_card_id, user_id, address_id, product_id, date_created) VALUES('".$new_subscription['id']."', '".$card_id."', '".$user_id."', '".$address_id."','".$product_id."', now())");

	$_SESSION['checkout_success'] = $product_info['name'];
	header('Location: subscribe_checkout_success.php');
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
				<div class="col-md-offset-1">
			<h3>DESCRIPCI&Oacute;N</h3>

			<div class="row">
				<div class="col-md-3">
					<div class="thumbnail">
						<img src="<?= $product_info['image']; ?>">
						<div class="caption">
							<h3><?= $product_info['name']; ?></h3>
							<p><?= $product_info['description']; ?></p>
							<p><?= $product_info['price']; ?></p>
						</div>
					</div>
				</div>	
			</div>


			<form action="subscribe_checkout.php?product_id=<?= $_GET['product_id']?>" method="post">
				<input type="hidden" name="action" value="process">
				<h3>SELECCIONA TARJETA</h3>
				<?php while ($payment = mysql_fetch_array($payment_query)) : 
					$card_info = Stripe_Customer::retrieve($stripe_customer_id)->cards->retrieve($payment['stripe_card_id']);
				?>
				<p>
					<div class="radio">
					  <label>
					   	<input type="radio" name="card_id" value="<?= $payment['stripe_card_id'] ?>" >
					   	<?= $card_info['type'].'-'.$card_info['last4'] ?> </br>
					   	<?= $card_info['exp_month'].'/'.$card_info['exp_year'] ?>
					  </label>
					</div>
				</p> 	
				<?php endwhile; ?>

			<h3>SELECCIONA DIRECCI&Oacute;N</h3>

			<?php while ($address = mysql_fetch_array($addresses_query)) : 
			?>
				<p>
					<div class="radio">
					  <label>
					   	<input type="radio" name="address_id" value="<?= $address['id'] ?>" >
					   	<p>Calle: <?=  $address['calle'] ?></p>
					   	<p>Colonia: <?=  $address['colonia'] ?></p>
					   	<p>Ciudad: <?=  $address['ciudad'] ?></p>
					   	<p>C&oacute;digo Postal: <?=  $address['codigo_postal'] ?></p>
					  </label>
					</div>
				</p> 	
			<?php endwhile; ?>

			<div class="row">
				<input type="submit" class="btn btn-success" value="Confirmar">
			</div>
			</form>
			</div>
		</div> <!-- row -->
		</div> 
	</body>
</html>
