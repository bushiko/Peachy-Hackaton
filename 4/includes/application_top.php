<?php

require('configure.php');
require(DIR_CLASSES.'PassHash.php');

//Connect to Database
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)  or die('Imposible conectarse a la Base de Datos');
mysql_select_db(DB_DATABASE_NAME);

//Session
session_start();


//Initialize Stripe
//NOTE: REQUIRES CURL PHP EXTENSION TO BE ENABLED.
require_once(DIR_LIBS.'stripe-php/lib/Stripe.php');
Stripe::setApiKey(STRIPE_TEST_SK);

//Initialize MailChimp
require_once(DIR_CLASSES.'MailChimp.php');
$MailChimp = new \Drewm\MailChimp(MAILCHIMP_KEY);
?>