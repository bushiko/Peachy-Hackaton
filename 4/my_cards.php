<?php
	include('includes/application_top.php');

	if(!isset($_SESSION['user_id'])) 
		header('Location: login.php');


	$user_id = $_SESSION['user_id'];
	$stripe_customer_id = $_SESSION['stripe_customer_id'];

	if(isset($_POST['action']) && $_POST['action'] === 'process') {
		$stripeToken = $_POST['stripeToken'];
		$new_card = Stripe_Customer::retrieve($stripe_customer_id)->cards->create(array("card" => $stripeToken));
		mysql_query("INSERT INTO cards_book(stripe_card_id, user_id, date_created) VALUES('".$new_card->id."', '".$user_id."', now())");
	}


	$cards_query = mysql_query("SELECT * FROM cards_book WHERE user_id = '".$user_id."'");
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
					<?php while($card = mysql_fetch_array($cards_query)) : 
						$card_info = Stripe_Customer::retrieve($stripe_customer_id)->cards->retrieve($card['stripe_card_id']);
					?>
						
				
				 		<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"> <?= $card_info['type'].'-'.$card_info['last4'] ?> </h3>
							</div>
							<div class="panel-body">
								<p>Ultimos 4 d&iacute;gitos: <?= $card_info['last4'] ?></p>
								<p>Fecha de expiraci&oacute;n: <?= $card_info['exp_month'].'/'.$card_info['exp_year'] ?></p>
								<p>Pa&iacute;s: <?= $card_info['country'] ?></p>
							</div>
						</div> 

					<?php endwhile; ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<input type="button" class="btn btn-primary" value="A&ntilde;adir Tarjeta" data-toggle="collapse" data-target="#new_card_div">
				</div>
			</div>

			<div class="row">&nbsp;</div>

			<div class="row">
				<div class="col-md-8 col-md-offset-2 well collapse" id="new_card_div" >
					<form class="form-horizontal" id="new_card_form" name="new_card_form" method="post">
						<input type="hidden" name="action" value="process">
						<div class="payment-errors alert alert-danger hide"></div>

						<div class="form-group">
							<label class="col-sm-2">Card Number</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" size="20" data-stripe="number" placeholder="5200828282828210">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2">CVC</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" size="4" data-stripe="cvc" placeholder="111">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2">
							Expiration (MM/YYYY)
							</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" size="2" data-stripe="exp-month" placeholder="12">
							</div>
							<div class="col-sm-1"> <h4>/</h4> </div>
							<div class="col-sm-2">
								<input type="text" class="form-control" size="4" data-stripe="exp-year" placeholder="2014">
							</div>
						</div>

						<div class="form-group">
							<input type="submit" class="btn btn-success continue" value="A&ntilde;adir"/>
						</div>
					</form>
				</div>
			</div>

		</div> <!-- container -->
	</body>
	<!-- Le js -->
	<script type="text/javascript">
		// This identifies your website in the createToken call below
		Stripe.setPublishableKey('<?= STRIPE_TEST_PK ?>');
			jQuery(function($) {
			$('#new_card_form').submit(function(event) {
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
			var $form = $('#new_card_form');

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
		</script>
</html>