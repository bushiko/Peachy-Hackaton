<?php
	include('includes/application_top.php');

	$products_query = mysql_query("SELECT * from products");

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

				<?php while ( $product = mysql_fetch_array($products_query) ) : ?>

				<div class="col-md-3">
					<div class="thumbnail">
						<img src="<?= $product['image']; ?>">
						<div class="caption">
							<h3><?= $product['name']; ?></h3>
							<p><?= $product['description']; ?></p>
							<p><?= $product['price']; ?></p>
							<p class="text-center"><a href="subscribe_checkout.php?product_id=<?= $product['id']; ?>" class="btn btn-success" role="button">Subscribe Me</a></p>
						</div>
					</div>
				</div>			

				<?php endwhile; ?>	

			</div>
		</div>
	</body>
</html>