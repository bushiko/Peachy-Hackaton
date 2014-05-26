<?php 

include('includes/application_top.php');

unset($_SESSION['user_id']);
unset($_SESSION['stripe_customer_id']);
header('Location: index.php');
?>