<?php
	include('includes/application_top.php');

	if(isset($_POST['action']) && $_POST['action'] === 'process') {

		$token = $_POST['stripeToken'];
		$mail = $_POST['mail'];
		$password = PassHash::hash($_POST['password']);
		$username = $_POST['username'];

		$calle = $_POST['calle'];
		$colonia = $_POST['colonia'];
		$ciudad = $_POST['ciudad'];
		$codigo_postal = $_POST['codigo_postal'];

		$stripe_customer = Stripe_Customer::create(array(
		  "card" => $token,
		  "description" => $mail
		));

		//save User
		mysql_query("INSERT INTO users(mail, username, password, default_address_id, stripe_customer_id, date_created) VALUES('".$mail."', '".$username."', '".$password."', NULL, '".$stripe_customer->id."', now())");
		$user_id = mysql_insert_id();
		$_SESSION['user_id'] = $user_id;
		$_SESSION['stripe_customer_id'] = $stripe_customer->id;

		//save address
		mysql_query("INSERT INTO address_book(user_id, calle, colonia, ciudad, codigo_postal) VALUES('".$user_id."', '".$calle."', '".$colonia."', '".$ciudad."', '".$codigo_postal."')");
		$address_default_id = mysql_insert_id();
		mysql_query("UPDATE users SET default_address_id = '".$address_default_id."' where user_id = '".$user_id."'");

		//saveStripeCustomer
		$card_info = Stripe_Customer::retrieve($stripe_customer->id)->cards->data[0];
		mysql_query("INSERT INTO cards_book(stripe_card_id, user_id, date_created) VALUES('".$card_info['id']."', ".$user_id.", now())");

		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require(DIR_MODULES.'head_includes.php'); ?>
		<style type="text/css">
		#personal, #shipping, #payment {
			padding: 20px;
		}
		</style>
	</head>
	<body>
		<?php require(DIR_MODULES.'navbar.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
 					<h2>Crea una cuenta</h2>

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" id="myTab">
					  <li class="active"><a href="#personal" data-toggle="tab">Personal</a></li>
					  <li><a href="#shipping" data-toggle="tab">Env&iacute;o</a></li>
					  <li><a href="#payment" data-toggle="tab">Pago</a></li>
					</ul>

					<form class="form-horizontal" name="signup" id="signup_form" action="signup.php" method="POST">
					<input type="hidden" name="action" value="process">
					<!-- Tab panes -->
					<div class="tab-content">

						<div class="tab-pane fade in active" id="personal">
							<div class="form-group">
								<label class="col-sm-2" for="mail">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" name="mail" placeholder="Enter email">
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-2" for="username">Username</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="username" placeholder="Username">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2" for="password">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="password" placeholder="Password">
								</div>
							</div>
							<a class="btn btn-success continue">Siguiente</a>
						</div>

						<div class="tab-pane fade" id="shipping">
							<div class="form-group">
								<label class="col-sm-2">Calle</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="calle" size="30">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2">Colonia</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="colonia" size="30">
								</div>
							</div>						

							<div class="form-group">
								<label class="col-sm-2">Ciudad</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="ciudad" size="30">
								</div>
							</div>						

							<div class="form-group">
								<label class="col-sm-2">C&oacute;digo Postal</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="codigo_postal" size="30">
								</div>
							</div>

							<a class="btn btn-success continue">Siguiente</a>
						</div>

						<div class="tab-pane fade" id="payment">
							<div class="payment-errors alert alert-danger hide"></div>

							<div class="form-group">
								<label class="col-sm-2">Card Number</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" size="20" data-stripe="number" value="4242424242424242">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2">CVC</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" size="4" data-stripe="cvc" value="323">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2">
								Expiration (MM/YYYY)
								</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" size="2" data-stripe="exp-month" value="12">
								</div>
								<div class="col-sm-1"> <h4>/</h4> </div>
								<div class="col-sm-2">
									<input type="text" class="form-control" size="4" data-stripe="exp-year" value="2014">
								</div>
							</div>


							<div class="form-group">
							<button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#help">
							  Ayuda
							</button>

							<input type="submit" class="btn btn-success continue" value="Enviar"/>
							</div>

							<div id="help" class="well collapse">
								<p>En CVC cualquier n&uacute;mero con dos d&iacute;gitos ser&aacute; correcto</p>
								<p>Cualquier Fecha futura servir&aacute; en Expiration</p>
								<p>Puedes usar los siguientes n&uacute;meros de tarjeta proporcionados por Stripe:</p>
								<p>NOTA: Para el uso de divisa Mexicana es recomendable elegir Visa o Mastercard, cualquier otra no permitirá subscripciones con moneda mexicana.</p>
								<table>
								  <thead>
								    <tr><th>Number</th>
								    <th>Card type</th>
								  </tr></thead>
								  <tbody>
								    <tr><td class="number"><code>4242<span></span>4242<span></span>4242<span></span>4242</code></td><td>Visa</td></tr>
								    <tr><td class="number"><code>4012<span></span>8888<span></span>8888<span></span>1881</code></td><td>Visa</td></tr>
								    <tr><td class="number"><code>4000<span></span>0566<span></span>5566<span></span>5556</code></td><td>Visa (debit card)</td></tr>
								    <tr><td class="number"><code>5555<span></span>5555<span></span>5555<span></span>4444</code></td><td>MasterCard</td></tr>
								    <tr><td class="number"><code>5105<span></span>1051<span></span>0510<span></span>5100</code></td><td>MasterCard</td></tr>
								    <tr><td class="number"><code>5200<span></span>8282<span></span>8282<span></span>8210</code></td><td>MasterCard (debit card)</td></tr>
								    <tr><td class="number"><code>3782<span></span>822463<span></span>10005</code></td><td>American Express</td></tr>
								    <tr><td class="number"><code>3714<span></span>496353<span></span>98431</code></td><td>American Express</td></tr>
								    <tr><td class="number"><code>6011<span></span>1111<span></span>1111<span></span>1117</code></td><td>Discover</td></tr>
								    <tr><td class="number"><code>6011<span></span>0009<span></span>9013<span></span>9424</code></td><td>Discover</td></tr>
								    <tr><td class="number"><code>3056<span></span>9309<span></span>0259<span></span>04</code></td><td>Diners Club</td></tr>
								    <tr><td class="number"><code>3852<span></span>0000<span></span>0232<span></span>37</code></td><td>Diners Club</td></tr>
								    <tr><td class="number"><code>3530<span></span>1113<span></span>3330<span></span>0000</code></td><td>JCB</td></tr>
								    <tr><td class="number"><code>3566<span></span>0020<span></span>2036<span></span>0505</code></td><td>JCB</td></tr>
								  </tbody>
								</table>
							</div>
						</div>

					</div>

					</form>
				</div>
			</div>
		</div>
	</body>
	<!-- Le js -->

	<!-- STRIPE.JS! -->
	<script type="text/javascript">
		// This identifies your website in the createToken call below
		Stripe.setPublishableKey('<?= STRIPE_TEST_PK ?>');
			jQuery(function($) {
			$('#signup_form').submit(function(event) {
			var $form = $(this);

			$form.find('.payment-errors').text('').addClass('hide');

			// Disable the submit button to prevent repeated clicks
			$form.find('button').prop('disabled', true);

			Stripe.card.createToken($form, stripeResponseHandler);

			// Prevent the form from submitting with the default action
			return false;
			});
		});

		var stripeResponseHandler = function(status, response) {
			console.log(status, response);
			var $form = $('#signup_form');

			if (response.error) {
				// Show the errors on the form
				$form.find('.payment-errors').text(response.error.message).removeClass('hide');
				$form.find('button').prop('disabled', false);
			} else {
				// token contains id, last4, and card type
				var token = response.id;
				// Insert the token into the form so it gets submitted to the server
				$form.append($('<input type="hidden" name="stripeToken" />').val(token));
				// and submit
				$form.get(0).submit();
			}
		};

		$("#signup_form").bind("keypress", function (e) {
		    if (e.keyCode == 13) {
		        console.log($(this));
		        return false;
		    }
		});

		$(function () {
			$('#personal a.continue').click(function() {
				$('a[href="#shipping"]').tab('show');
			});			
			$('#shipping a.continue').click(function() {
				$('a[href="#payment"]').tab('show');
			});
		})
	</script>
</html>